<?php
echo "<script>
                    $(document).ready(function(){
                        $('#status').load('ruolo/tablestatus.php')
                        setInterval(function(){
                            $('#status').load('ruolo/tablestatus.php')
                        },900);
                    });
                  </script>";


echo "<div id='status'>  </div>";

                            