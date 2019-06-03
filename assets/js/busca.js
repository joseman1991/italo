/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    var bton = $('#bton');
    var lista = $('#pacientes');
    var caja = $('#paciente');
    var lista2 = $('#medicinas');
    var caja2 = $('#medicina');
    $.ajax({
        type: 'POST',
        url: 'buscar.php',
        data: 'op=' + 1,
        success: function (html) {
            var obj = JSON.parse(html);
            $.each(obj, function (key, value) {
                lista.append("<option data-ejemplo=" + value.codusuario + " value='" + value.nombre + "'>");
            });
        }
    });

    $.ajax({
        type: 'POST',
        url: 'buscar.php',
        data: 'op=' + 2,
        success: function (html) {
            var obj = JSON.parse(html);
            $.each(obj, function (key, value) {
                lista2.append("<option data-ejemplo=" + value.idmedicina + " value='" + value.descripcion + "'>");
            });
        }
    });

    var iu = $('#iu');

    caja.change(function () {
        var val = caja.val();
        var ejemplo = lista.find('option[value="' + val + '"]').data('ejemplo');
        iu.val(ejemplo);
    });


    var codigo;
    var nombre;
    caja2.change(function () {
        nombre = caja2.val();
        codigo = lista2.find('option[value="' + nombre + '"]').data('ejemplo');

    });


    bton.click(function () {
        var tbody = $('#example').find('tbody');
        var fila = $((document).createElement('tr'));
        if (codigo !== null || codigo !== undefined) {
            
            var number = $((document).createElement('input'));
            number.attr('type', 'text');            
            number.attr('name', 'cod[]');
            number.attr('value', codigo);
            number.attr('readonly', "true");
            number.addClass('form-control');
            
            var campo = $((document).createElement('td'));
//            var nombreCampo = $((document).createTextNode(codigo));
            campo.append(number);
            fila.append(campo);

            var number = $((document).createElement('input'));
            number.attr('type', 'number');
            number.attr('min', 1);
            number.attr('name', 'cantidad[]');
            number.attr('value', 1);
            number.addClass('form-control');

            var campo = $((document).createElement('td'));
            campo.append(number);
            fila.append(campo);
            var campo = $((document).createElement('td'));
            campo.append(nombre);
            fila.append(campo);
            var campo = $((document).createElement('td'));
            var select = $((document).createElement('select'));
            select.addClass('sel');
            select.attr('name', 'dosis[]');
            select.append('<option>Cada 3 horas</option>');
            select.append('<option>Cada 6 horas</option>');
            select.append('<option>Cada 8 horas</option>');
            select.append('<option>Cada 12 horas</option>');
            select.append('<option>Cada 24 horas</option>');
            select.addClass('form-control');
            campo.append(select);
            fila.append(campo);
            var campo = $((document).createElement('td'));
            var text = $((document).createElement('input'));
            text.attr('type', 'text');
            text.attr('name', 'observ[]');
            text.addClass('form-control');
            campo.append(text);
            fila.append(campo);
            tbody.append(fila);
            caja2.val('');
           
        }
    });


});
