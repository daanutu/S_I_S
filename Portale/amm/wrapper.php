<?php

	echo "<script>
                    $(document).ready(function(){
                        $('#nallarmi').load('ruolo/countallarmiincorso.php')
						$('#ncontatti').load('ruolo/countcontatti.php')
						$('#nrichieste').load('amm/countrichieste.php')
                        setInterval(function(){
                            $('#nallarmi').load('ruolo/countallarmiincorso.php')
							$('#ncontatti').load('ruolo/countcontatti.php')
							$('#nrichieste').load('amm/countrichieste.php')
                        },900);
                    });
                  </script>";

	echo "<div class='wrapper'>
			<div class='row'>

			<div class='col-3 col-m-6 col-sm-6'>
				<div class='counter bg-warning'>
					<p>
						<i class='fas fa-hands-wash'></i>
					</p>
					<h3 id='ncontatti'></h3>
					<p>Dispositvi a contatto oggi</p>
				</div>
			</div>
			
			<div class='col-3 col-m-6 col-sm-6'>
				<div class='counter bg-danger'>
					<p>
						<i class='fas fa-exclamation-triangle'></i>
					</p>
					<h3 id='nallarmi'></h3>
					<p>Dispositvi in allarme</p>
				</div>
			</div>

			<div class='col-3 col-m-6 col-sm-6'>
				<div class='counter bg-primary'>
					<p>
						<i class='fas fa-users'></i>
					</p>
					<h3 id='nrichieste'></h3>
					<p>Richieste di registrazione</p>
				</div>
			</div>

		</div></div>";

