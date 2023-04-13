export function exportExcel(data, nameFile){

    function exporting () {
        import('xlsx').then(xlsx => {
            const worksheet = xlsx.utils.json_to_sheet(data);
            const workbook = { Sheets: { 'data': worksheet }, SheetNames: ['data'] };
            const excelBuffer = xlsx.write(workbook, { bookType: 'xlsx', type: 'array' });
            saveAsExcelFile(excelBuffer, nameFile+' Export ');
        });
    }

    return {exporting}

    function saveAsExcelFile  (buffer, fileName)  {
        import('file-saver').then(module => {
            if (module && module.default) {
                let EXCEL_TYPE = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8';
                let EXCEL_EXTENSION = '.xlsx';
                const data = new Blob([buffer], {
                    type: EXCEL_TYPE
                });
                module.default.saveAs(data, fileName +  new Date().getTime() + EXCEL_EXTENSION);
            }
        });
    }
}

// export function filasExcel(filename){
//     var filas = 0;
//     import('xlsx').then(xlsx => {
//         console.log(filename);
//         const wb = xlsx.readFile(filename);
//         filas = wb.Sheets[wb.SheetNames[0]].length;
//         console.log(filas);

//     });
//     return {filas};
// }
