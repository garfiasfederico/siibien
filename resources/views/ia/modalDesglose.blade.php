<div class="modal fade" id="modalDesglose" tabindex="-1" role="dialog" aria-labelledby="accionModalLabelDesglose"
    data-backdrop="static" data-keyboard="false" aria-hidden="true" style="color:black!important">

    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header" style="background-color:rgb(157, 36, 73); color:white; padding:15px 20px;">
                <h5 class="modal-title" id="accionModalLabelDesglose">
                    Información del desglose
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body" style="padding:20px;">

                <div id="nombreBienServicio" style="margin-bottom:15px;font-weight:bold;font-size:1.05em;">
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="border rounded mb-3">
                            <div
                                style="background-color:rgb(157, 36, 73); color:white; padding:8px 12px; font-weight:600;">
                                Desglose municipal
                            </div>
                            <div class="p-3" id="desgloseMunicipal">
                                <div class="text-muted text-center">
                                    Sin información
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border rounded mb-3">
                            <div
                                style="background-color:rgb(157, 36, 73); color:white; padding:8px 12px; font-weight:600;">
                                Desglose regional
                            </div>
                            <div class="p-3" id="desgloseRegional">
                                <div class="text-muted text-center">
                                    Sin información
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer" style="padding:10px 20px;">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>