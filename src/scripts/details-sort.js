function loadDetailsSort() {
    const getSort = ({ target }) => {
        const order = (target.dataset.order = -(target.dataset.order || -1));
        const index = [...target.parentNode.cells].indexOf(target);
        const collator = new Intl.Collator(['ar', 'bg', 'cs', 'de', 'en', 'es', 'fr', 'ko', 'ro', 'ru', 'sk', 'tr', 'zh'], { numeric: true });
        const comparator = (index, order) => (a, b) => order * collator.compare(
            a.children[index].innerHTML,
            b.children[index].innerHTML
        );
        for(const tBody of target.closest('table').tBodies)
            tBody.append(...[...tBody.rows].sort(comparator(index, order)));
        for(const cell of target.parentNode.cells)
            cell.classList.toggle('sorted', cell === target);
    };
    document.querySelectorAll('.players_table .table_head, .settings_table .table_head').forEach(tableTH => tableTH.addEventListener('click', () => getSort(event)));
}

document.addEventListener("DOMContentLoaded", loadDetailsSort);

let st = document.createElement("style");
st.innerText = `
.table_head th { cursor: pointer; }
.table_head th:hover:after {
  content: "↕";
}`;
document.body.appendChild(st);