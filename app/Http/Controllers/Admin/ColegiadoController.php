<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Colegiado;
use App\Models\Habilitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ColegiadoController extends Controller
{
    /**
     * Listar todos los colegiados con paginación y ordenamiento
     */
    public function index(Request $request)
    {
        $query = Colegiado::query();

        // Búsqueda
        if ($request->filled('buscar')) {
            $query->buscar($request->buscar);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Ordenamiento - Solo permitir columnas específicas por seguridad
        $sortableColumns = ['codigo_cpap', 'dni', 'nombres', 'apellidos', 'especialidad', 'estado', 'fecha_colegiatura', 'created_at'];
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');

        // Validar que sort sea una columna permitida
        if (!in_array($sort, $sortableColumns)) {
            $sort = 'created_at';
        }

        // Validar dirección (asc o desc)
        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'desc';
        }

        $colegiados = $query->orderBy($sort, $order)->paginate(10);

        // Pasar variables de ordenamiento a la vista
        return view('admin.colegiados.index', compact('colegiados', 'sort', 'order'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('admin.colegiados.create');
    }

    /**
     * Guardar nuevo colegiado
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_cpap' => 'required|string|max:50|unique:colegiados,codigo_cpap',
            'dni' => 'required|string|size:8|unique:colegiados,dni',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'nullable|email|max:100|unique:colegiados,email',
            'telefono' => 'nullable|string|max:15',
            'fecha_nacimiento' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'especialidad' => 'nullable|string|max:150',
            'universidad' => 'nullable|string|max:200',
            'anio_graduacion' => 'nullable|integer|min:1950|max:' . date('Y'),
            'descripcion' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf|max:5120',
            'estado' => 'required|in:activo,inactivo',
            'fecha_colegiatura' => 'required|date',
        ]);

        // Upload de foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nombreFoto = $validated['dni'] . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('images/colegiados'), $nombreFoto);
            $validated['foto'] = 'images/colegiados/' . $nombreFoto;
        }

        // Upload de CV
        if ($request->hasFile('cv')) {
            $cv = $request->file('cv');
            $nombreCV = $validated['dni'] . '_cv.pdf';
            $cv->storeAs('cv', $nombreCV);
            $validated['cv_path'] = 'cv/' . $nombreCV;
        }

        // Crear colegiado
        Colegiado::create($validated);

        return redirect()->route('admin.colegiados.index')
            ->with('success', 'Colegiado registrado exitosamente.');
    }

    /**
     * Mostrar detalle del colegiado
     */
    public function show(Colegiado $colegiado)
    {
        // Cargar relación de habilitaciones
        $colegiado->load('habilitaciones');

        return view('admin.colegiados.show', compact('colegiado'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Colegiado $colegiado)
    {
        return view('admin.colegiados.edit', compact('colegiado'));
    }

    /**
     * Actualizar colegiado
     */
    public function update(Request $request, Colegiado $colegiado)
    {
        $validated = $request->validate([
            'codigo_cpap' => 'required|string|max:50|unique:colegiados,codigo_cpap,' . $colegiado->id,
            'dni' => 'required|string|size:8|unique:colegiados,dni,' . $colegiado->id,
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'nullable|email|max:100|unique:colegiados,email,' . $colegiado->id,
            'telefono' => 'nullable|string|max:15',
            'fecha_nacimiento' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'especialidad' => 'nullable|string|max:150',
            'universidad' => 'nullable|string|max:200',
            'anio_graduacion' => 'nullable|integer|min:1950|max:' . date('Y'),
            'descripcion' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf|max:5120',
            'estado' => 'required|in:activo,inactivo',
            'fecha_colegiatura' => 'required|date',
        ]);

        // Upload de nueva foto
        if ($request->hasFile('foto')) {
            // Eliminar foto anterior
            if ($colegiado->foto && File::exists(public_path($colegiado->foto))) {
                File::delete(public_path($colegiado->foto));
            }

            $foto = $request->file('foto');
            $nombreFoto = $validated['dni'] . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('images/colegiados'), $nombreFoto);
            $validated['foto'] = 'images/colegiados/' . $nombreFoto;
        }

        // Upload de nuevo CV
        if ($request->hasFile('cv')) {
            // Eliminar CV anterior
            if ($colegiado->cv_path && Storage::exists($colegiado->cv_path)) {
                Storage::delete($colegiado->cv_path);
            }

            $cv = $request->file('cv');
            $nombreCV = $validated['dni'] . '_cv.pdf';
            $cv->storeAs('cv', $nombreCV);
            $validated['cv_path'] = 'cv/' . $nombreCV;
        }

        // Actualizar colegiado
        $colegiado->update($validated);

        // Sincronizar habilitación con el nuevo estado
        Habilitacion::where('colegiado_id', $colegiado->id)
            ->update(['activo' => $validated['estado'] === 'activo']);

        return redirect()->route('admin.colegiados.show', $colegiado)
            ->with('success', 'Colegiado actualizado exitosamente.');
    }

    /**
     * Eliminar colegiado
     */
    public function destroy(Colegiado $colegiado)
    {
        // Eliminar foto
        if ($colegiado->foto && File::exists(public_path($colegiado->foto))) {
            File::delete(public_path($colegiado->foto));
        }

        // Eliminar CV
        if ($colegiado->cv_path && Storage::exists($colegiado->cv_path)) {
            Storage::delete($colegiado->cv_path);
        }

        // Eliminar colegiado (las habilitaciones se eliminan en cascada)
        $colegiado->delete();

        return redirect()->route('admin.colegiados.index')
            ->with('success', 'Colegiado eliminado exitosamente.');
    }

    /**
     * Descargar CV del colegiado (inline PDF)
     */
    public function descargarCV(Colegiado $colegiado)
    {
        if (!$colegiado->cv_path || !Storage::exists($colegiado->cv_path)) {
            abort(404, 'CV no disponible');
        }

        $nombre = 'CV_' . $colegiado->codigo_cpap . '.pdf';

        return response()->file(Storage::path($colegiado->cv_path), [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombre . '"',
        ]);
    }

    /**
     * Toggle estado activo/inactivo
     *
     * Al cambiar el estado, sincroniza la habilitación del colegiado:
     * - ACTIVO  → reactiva su documento de habilitación (si tiene)
     * - INACTIVO → revoca su documento de habilitación (si tiene)
     */
    public function toggleEstado(Colegiado $colegiado)
    {
        $nuevoEstado = $colegiado->estado === 'activo' ? 'inactivo' : 'activo';
        $colegiado->update(['estado' => $nuevoEstado]);

        // Sincronizar habilitación usando query directa (evita problemas de caché del modelo)
        Habilitacion::where('colegiado_id', $colegiado->id)
            ->update(['activo' => $nuevoEstado === 'activo']);

        $mensaje = $nuevoEstado === 'activo'
            ? 'Colegiado activado. Su documento de habilitación fue reactivado.'
            : 'Colegiado desactivado. Su documento de habilitación fue revocado.';

        return redirect()->back()->with('success', $mensaje);
    }
}
