<div class="modal fade modal-password" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
    style="z-index:1600">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #919090; color:white">
                <h5 class="modal-title">Cambiar Contraseña de Acceso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding:25px;">
                <form id="formPassword" action="{{ route('perfil.changepassword') }}">
                    <div class="row">
                        @csrf
                        <table style="width:100%">
                            <tr>
                                <td style="width:30%">
                                    <label for="passwordactual">Contraseña Actual:<span
                                            style="color: red">*</span></label>
                                </td>
                                <td style="width:35%">
                                    <input type="password" class="form-control pass" id="passwordactual" placeholder=""
                                        value="" style="text-align:left;"required name="passwordactual" />
                                    <div class="invalid-feedback">
                                        Indique la Constraseña Actual
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%">
                                    <label for="password">Nueva Contraseña:<span style="color: red">*</span></label>
                                </td>
                                <td colspan="2">
                                    <input type="password" class="form-control pass" id="passwordnueva" placeholder=""
                                        value="" style="text-align:left;"required name="passwordnueva" />
                                    <div class="invalid-feedback">
                                        Indique contraseña nueva!
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%">
                                    <label for="passwordnueva">Confirme Contraseña:<span
                                            style="color: red">*</span></label>
                                </td>
                                <td colspan="2">
                                    <input type="password" class="form-control pass" id="passwordconfirmada" placeholder=""
                                        value="" style="text-align:left;" required name="passwordconfirmada" />
                                    <div class="invalid-feedback">
                                        Confirmación incorrecta!
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%">
                                    <label for="mostrar">Mostrar:</label>
                                </td>
                                <td colspan="2">
                                    <input type="checkbox" class="" id="mostrar" placeholder="" value=""
                                        style="text-align:left;" required name="mostrar" onclick="$(this).prop('checked')?$('.pass').attr('type','text'):$('.pass').attr('type','password')"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="sendChange()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<style>
    .swal2-container {
        z-index: 1800;
    }
</style>
<script>
    function changePassword(idUser) {
        $("#passwordactual").val("");
        $("#passwordnueva").val("");
        $("#passwordconfirmada").val("");
        $(".modal-password").modal("show");
    }

    function sendChange() {
        if (validapasswords()) {
            $.ajax({
                type: 'POST',
                url: $("#formPassword").attr('action'),
                data: $("#formPassword").serialize(),
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                block(false);
                if (response.success == "ok") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Contraseña actualizada correctamente!',
                        text: response.message,
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        $(".modal-password").modal("hide")
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Contraseña no actualizada',
                        text: response.message,
                        confirmButtonColor: '#3085d6',
                    })
                }
            }).fail(function(data) {
                block(false);
            })
        }

    }

    function validapasswords() {
        inputs = [
            "passwordactual",
            "passwordnueva",
            "passwordconfirmada"
        ];

        valid = true;

        for (var x = 0; x < inputs.length; x++) {
            if ($("#" + inputs[x]).val().trim().length == 0) {
                $("#" + inputs[x]).addClass("is-invalid");
                valid = false;
            } else {
                $("#" + inputs[x]).removeClass("is-invalid");
            }
        }

        if (valid) {
            if (($("#passwordnueva").val() != $("#passwordconfirmada").val())) {
                $("#passwordconfirmada").addClass("is-invalid");
                valid = false;

            } else {
                $("#passwordconfirmada").removeClass("is-invalid");
                valid = true;
            }

        }
        return valid;
    }
</script>
