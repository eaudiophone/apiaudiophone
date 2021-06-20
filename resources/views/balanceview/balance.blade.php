<!DOCTYPE html>
<html lang="es">
	
	<head>

		<!-- META TAGS REQUIRED -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta charset="UTF-8">

		<style>
				
			body
			{
				font-family: sans-serif;
			}

			table
			{
				width: auto;
				border: solid;
			}

			thead tr th
			{
				text-align: center;
				background-color: black;
				color: white;
			}

			tbody tr td
			{
				text-align: center;
			}
		</style>
		
		<title>Balance CLiente</title>
	</head>
	
	<body>

		<!--         CABECERA DEL REPORTE          -->

		<header>
			
			<div class="container">
				
				<h1>Estudio Audiophone S.A.</h1>

				<div class="row">
					
					<div class="col-12 col-sm-6">
						
						<p>Caracas</p><!-- Variable Fecha del día debe venir del controller--><br/>
						<p>Nombre:</p><!-- Variable Nombre--><br/>
						<p>C.I:</p><!-- Variable Identificación--><br/>
						<p>Teléfono:</p><!-- Variable Teléfono--><br/>
					</div>
				</div>
			</div>
		</header>
		
		<!--         CUERPO DEL REPORTE          -->
		
		<main>
			
			<div class="container">

				<h2>Balance General</h2>
				
				<table class="table">
					
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Descripción</th>
							<th>Horas Laboradas</th>
							<th>Debe</th>
							<th>Haber</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						

						@foreach() <!-- variables para ingresarlas en el reporte -->

							<tr>
								<td>hola<!-- variable del backend fecha --></td>
								<td>hola<!-- variable del backend descripcion --></td>
								<td>hola<!-- variable del backend Horas Laboradas --></td>
								<td>hola<!-- variable del backend Debe --></td>
								<td>hola<!-- variable del backend Haber --></td>
								<td>hola<!-- variable del backend Total --></td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td>
								<!-- Hasta los momentos no hay nada que colocar en el footer -->
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</main>
		<footer>

			<div class="container">
		
				<h5>Gracias por confiar en Estudios Audiophone S.A.</h5>
			</div>		
		</footer>	
	</body>
</html>