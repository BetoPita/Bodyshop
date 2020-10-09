<form id="frm-asignar-tecnico" method="post">
    <div class="form-group">
        <label for="nombretecnico">Tecnico</label>
        <select  name="nuevotecnico" class="form-control" id="nuevotecnico">
            <option value="0">Seleccionar tecnico</option>
            <?php foreach ($catalogo_tecnicos as $key => $tecnicos): ?>
                <option value="<?php echo $tecnicos->id ?>"><?php echo $tecnicos->tecnico ?></option>
            <?php endforeach ?>
        </select>
        <span class="error error_nuevotecnico"></span>
        <input type="hidden" value="<?php echo $proyectoIdTecnico; ?>" name="proyectoIdTecnico">
    </div>
</form>