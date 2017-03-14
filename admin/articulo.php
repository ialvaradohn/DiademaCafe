<!doctype html>
<?php
	$db = new MySQLi('localhost', 'root', 'Dwacsb1897', 'diademacafe');
	
	
	if ($db -> connect_errno) {
		die('Revisar la conexion de la base de datos, datos erroneos');
	}

	$userQuery = 'SELECT articuloId, articuloDesc, articuloPrecio, articuloCodBarra FROM articulo';
	$stmt = $db->query($userQuery);
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Administracion - Articulo</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript">
            $(document).ready(function() {
                var textBefore = '';
                $('#grid').find('td input').hover(function() {
                    textBefore = $(this).val();
                    $(this).focus();
                }, function() {
                    var $field = $(this),
                        text = $field.val();
                    $(this).blur();
                    // Set back previous value if empty
                    if (text.length <= 0) {
                        $field.html(textBefore);
                    } else if (textBefore !== text) {
                        // Text has been changed make query
                        var value = {
                            'row': parseInt(getRowData($field)),
                            'column': parseInt($field.closest('tr').children().find(':input').index(this)),
                            'text': text
                        };
                        $.post('articulo_grid.php', value)
                        .error(function() {
                            $('#message')
                                .html('Make sure you inserted correct data')
                                .fadeOut(3000)
                                .html('&nbsp');
                            $field.val(textBefore);
                        })
                        .success(function() {
                            $field.val(text);
                        });
                    } else {
                        $field.val(text);
                    }
 
                });
 
                // Get the id number from row
                function getRowData($td) {
                    return $td.closest('tr').prop('class').match(/\d+/)[0];
                }
            });
        </script>

	</head>

	<body>
		<?php if ($stmt): ?>
		
		<div id="grid">
		<p id="message">Click on the field to edit data</p>
		<table>
			<thead>
				<tr>
					<th>Codigo</th>
					<th>Descripcion</th>
					<th>Precio</th>
					<th>Codigo Barra</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $stmt->fetch_assoc()): ?>
					<tr class="<?php echo $row['articuloId']; ?>">
						<td><input type="text" value="<?php echo $row['articuloId']; ?>" /></td>
						<td><input type="text" value="<?php echo $row['articuloDesc']; ?>" /></td>
						<td><input type="text" value="<?php echo $row['articuloPrecio']; ?>" /></td>
						<td><input type="text" value="<?php echo $row['articuloCodBarra']; ?>" /></td>
					</tr>
				<?php endwhile; ?>
			</tbody>
			</table>
		</div>

		<?php else: ?>
			<p>No users added yet</p>
		<?php endif; ?>
	
	</body>
</html>
