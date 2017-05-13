function guardar(id){
                      var ids='';
                      var gesunos='';
                      var gesdoss='';
                      var areasuno='';
                      var areasdos='';
                      var usuarios1='';
                      var usuarios2='';
                      var opc='';
                      var nombres='';
                      //alert(document.getElementById("selectable").rows.length);
                        for(var i=1;i<document.getElementById("selectable").rows.length;i++)
                        {

                          var id= selectable.rows[i].cells[1].childNodes[0].nodeValue;                          

                          var nom= selectable.rows[i].cells[2].childNodes[0].nodeValue;                          

                          var gesuno = $("#guno_"+i+"").val();
                          var gesdos = $("#gdos_"+i+"").val();

                          var areauno = $("#areag1_"+i+"").val();
                          var areados = $("#areag2_"+i+"").val();

                          var usu = $("#usu_"+i+"").val();
                          var usu2 = $("#usu2_"+i+"").val();
                          var opcion="";
                          
                          if(gesuno!=''&&usu==''&&gesdos==''&&usu2=='')
                            {
                              opcion='gestion1';
                              ids+=id+'.,';
                              nombres+=nom+'.,';
                              opc+=opcion+'.,';
                              gesunos+=gesuno+'.,';
                              gesdoss+=gesdos+'.,';
                              areasuno+=areauno+'.,';
                              areasdos+=areados+'.,';
                              usuarios1+=usu+'.,';
                              usuarios2+=usu2+'.,';
                              //alert(selectable.rows[i].cells[0].childNodes[0].nodeValue+" "+gesuno+" "+gesdos+" "+areauno+" "+areados+" "+usu+" "+usu2+" "+opcion);
                              //guardarfiltro(gesuno, gesdos, areauno, areados, id, opcion);
                            }
                          if(gesuno!=''&&usu!=''&&gesdos!=''&&usu2=='')
                            {
                              opcion='gestion2';
                              ids+=id+'.,';
                              nombres+=nom+'.,';
                              opc+=opcion+'.,';
                              gesunos+=gesuno+'.,';
                              gesdoss+=gesdos+'.,';
                              areasuno+=areauno+'.,';
                              areasdos+=areados+'.,';
                              usuarios1+=usu+'.,';
                              usuarios2+=usu2+'.,';

                              //alert(selectable.rows[i].cells[0].childNodes[0].nodeValue+" "+gesuno+" "+gesdos+" "+areauno+" "+areados+" "+usu+" "+usu2+" "+opcion);
                              //guardarfiltro(gesuno, gesdos, areauno, areados, id, opcion);  
                            }


                          //antigua
                            //var gesuno = $("#guno_"+i+"").val();
                            //var gesdos = $("#gdos_"+i+"").val();

                            //var areauno = $("#areag1_"+i+"").val();
                            //var areados = $("#areag2_"+i+"").val();

                            //var id= selectable.rows[i].cells[1].childNodes[0].nodeValue;
                            //var nombre= selectable.rows[i].cells[2].childNodes[0].nodeValue;
                            //alert(nombre);
                            //var usu = $("#usu_"+i+"").val();
                            //var usu2 = $("#usu2_"+i+"").val();

                            //guardarfiltro(gesuno, gesdos, areauno, areados, id, opcion);
                        }
                        gesunos=gesunos.substr(0,gesunos.length-2);
                        gesdoss=gesdoss.substr(0,gesdoss.length-2);
                        areasuno=areasuno.substr(0,areasuno.length-2);
                        areasdos=areasdos.substr(0,areasdos.length-2);
                        ids=ids.substr(0,ids.length-2);
                        opc=opc.substr(0,opc.length-2);
                        nombres=nombres.substr(0,nombres.length-2);
                        //alert($("#sesi").val()); usuario
                        guardarfiltro(gesunos, gesdoss, areasuno, areasdos, ids, opc, nombres);
                        //consufiltro(tipos.value, desde.value, hasta.value, sucur.value);
                    }