document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.mv-tabs input');
    let index = 0;

    function activate(i) {
        tabs[i].checked = true;
        index = i;
    }

    setInterval(() => {
        index = (index + 1) % tabs.length;
        activate(index);
    }, 6500);

    tabs.forEach((tab, i) => {
        tab.addEventListener('click', () => activate(i));
    });

    activate(0);
});
