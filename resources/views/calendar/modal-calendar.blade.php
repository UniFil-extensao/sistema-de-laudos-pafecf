    <div class="modal fade" id="modalCalendar" tabindex="-1" aria-labelledby="titleModal" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModal">Editar Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="formEvent">
                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label">Título</label>
                            <div class="col-sm-8">
                                <input type="text" name="title" class="form-control" id="title">
                                <input type="text" name="id">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start" class="col-sm-4 col-form-label">Data e Hora Inicial</label>
                            <div class="col-sm-8">
                                <input type="text" name="start" class="form-control date-time" id="start">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end" class="col-sm-4 col-form-label">Data e Hora Final</label>
                            <div class="col-sm-8">
                                <input type="text" name="end" class="form-control date-time" id="end">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="color" class="col-sm-4 col-form-label">Cor do Evento</label>
                            <div class="col-sm-8">
                                <input type="color" name="color" class="form-control" id="color">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-4 col-form-label">Descrição do Evento</label>
                            <div class="col-sm-8">
                                <textarea name="description" id="description" cols="40" rows="4"></textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger delete-event">Excluir</button>
                    <button type="button" class="btn btn-primary save-event">Salvar Alterações</button>
                </div>

            </div>
        </div>
    </div>
