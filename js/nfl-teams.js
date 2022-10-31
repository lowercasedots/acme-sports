document.addEventListener("DOMContentLoaded", () => {

    const table = document.querySelector('.nfl-teams table');
    const headers = table.querySelectorAll('th');
    const tableBody = table.querySelector('tbody');
    const rows = tableBody.querySelectorAll('tr');

    //loop the headers to enable the click-to-sort functionality, and change the sort arrow direction
    headers.forEach((header, index) => {
        header.addEventListener("click", () => {
            header.querySelector('span').classList.toggle('asc');
            sortColumn(index);
        });
    });

    const sortColumn = function (index) {
        //get the current direction
        const direction = directions[index] || 'asc';

        //invert the output of the sort function if the direction is descending
        const modifier = (direction === 'asc') ? 1 : -1;

        //clone the current rows, then sort said rows by the content of the cells
        const newRows = Array.from(rows);

        newRows.sort(function (rowA, rowB) {
            const cellA = rowA.querySelectorAll('td')[index].innerHTML;
            const cellB = rowB.querySelectorAll('td')[index].innerHTML;

            switch (true) {
                case cellA > cellB:
                    return 1 * modifier;
                case cellA < cellB:
                    return -1 * modifier;
                case cellA === cellB:
                    return 0;
            }
        });

        //switch the direction so we can invert the sort on the next function call
        directions[index] = direction === 'asc' ? 'desc' : 'asc';

        //remove the unsorted rows and append the newly-sorted ones
        rows.forEach(function (row){
            tableBody.removeChild(row);
        });

        newRows.forEach(function (newRow) {
            tableBody.appendChild(newRow);
        });
    };

    //track the sort direction for each header
    const directions = Array.from(headers).map(function (header) {
        return '';
    });
});