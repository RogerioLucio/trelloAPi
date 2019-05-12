
<div class="registros">
  <h4><span class="glyphicon glyphicon-th-list"></span> Registros do board</h4>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Titulo do Board</th>
          <th>Descrição</th>
          <th>URL do Board</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if (count($registros) <= 0) {
            echo '<tr>';
            echo '<td colspan="5" class="text-center">Nenhum registro encontrado</td>';
            echo '</tr>';
          }else{
            foreach ($registros as $registro) {
        ?>
        <tr>
          <td><?php echo $registro->name; ?></td>
          <td><?php echo $registro->desc; ?></td>
          <td><a target="_blank" href="<?php echo $registro->url; ?>">Visitar o Board</a></td>
        </tr>
        <?php }
      } ?>
      </tbody>
    </table>
</div>
