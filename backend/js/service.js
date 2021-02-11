var request;
$('#addData').submit(function (event) {
    event.preventDefault();
    if (request) {
        request.abort();
    }
    var $form = $(this);

    var $inputs = $form.find('input, select, button, textarea');

    var serializedData = $form.serialize();
    $inputs.prop('disabled', true);
    request = $.ajax({
        url: url,
        type: 'post',
        data: serializedData,
    });

    request.done(function (response, textStatus, jqXHR) {
        SweetAlert('เรียบร้อย', 'success');
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        SweetAlert('ผิดพลาด', 'error');
    });

    request.always(function () {});
    location.reload();
});
