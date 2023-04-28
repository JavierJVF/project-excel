    


    const fecha = new Date();
    const hoy = fecha.getDate();
    const mesActual = fecha.getMonth() + 1; 
    const añoActual = fecha.getFullYear();

    const array_mes_string = {
        1 : 'Enero',
        2 : 'Febrero',
        3 : 'Marzo',
        4 : 'Abril',
        5 : 'Mayo',
        6 : 'Junio',
        7 : 'Julio',
        8 : 'Agosto',
        9 : 'septiembre',
        10 : 'Octubre',
        11 : 'Noviembre',
        12 : 'Diciembre',
    }

    var url = 'app/Data-store.php';

    

function importExcel()
{
    
    var formData = new FormData(document.getElementById("form_excel_import"));
    alertify.message('Procesando solicitud');
    $.ajax(
    {
        url: url,
        data: formData,
        type: 'POST',
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false,
        success: function(res)
        {
            console.log(res)
            res=JSON.parse(res)
            if (res.code == 200) 
            {
                alertify.success(res.mensaje);
                console.log(res.data)
            }else if (res.code == 403) 
            {
                alertify.error(res.mensaje);
            } else
            {
                alertify.error(res.mensaje); 
                console.log(res.data)
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            alertify.error('There were problems processing the petition');
        } 
    });
}