function loadXMLDoc(){
	var xmlhttp;
	var n=document.getElementById('idusuario').value;
	if(n==''){
		document.getElementById("consu").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("histopagos").innerHTML="";
			document.getElementById("prefacturapendiente").innerHTML="";
			document.getElementById("suspencionteporal").innerHTML="";
			document.getElementById("ordendesinstalacion").innerHTML="";
			document.getElementById("consu").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST","busquedainteligente.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("q="+n);
}

function loadXMLDoci(){
	var xmlhttp;
	var n=document.getElementById('ciusuario').value;

	if(n==''){
		document.getElementById("consu").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("histopagos").innerHTML="";
			document.getElementById("consu").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST","busquedaci.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("a="+n);
}

function consultahistorialpagos(ing){
	var xmlhttp;
	var n=ing;

	if(n==''){
		document.getElementById("histopagos").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("histopagos").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST","consultahistorialdepagos.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("q="+n);
}

function consultaprefacturapendiente(pre)
{

var xmlhttp;
var n=pre;

if(n==''){
document.getElementById("prefacturapendiente").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("prefacturapendiente").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","prefacturapendiente.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);
}


function suspencionestemporales(suspen)
{

var xmlhttp;
var n=suspen;

if(n==''){
document.getElementById("suspencionteporal").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("suspencionteporal").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","suspencionestemporales.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);
}

function ordenesdetrabajo(orde)
{

var xmlhttp;
var n=orde;

if(n==''){
document.getElementById("ordendesinstalacion").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("ordendesinstalacion").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","ordenestrab.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);
}

function factu(numerillo)
{
var xmlhttp;
var n=numerillo;

if(n==''){
document.getElementById("respu").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("respu").innerHTML=xmlhttp.responseText;
}
}

xmlhttp.open("POST","factura.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);

}

function cambiodirec(id, dire)
{
var xmlhttp;
var n=id;
var d=dire;

if(n==''){
document.getElementById("respu").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("respu").innerHTML=xmlhttp.responseText;
}
}

xmlhttp.open("POST","notificaciones_guardardir.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("id="+n+"&dir="+d);

}


function consufiltro(tip,des,hast,suc)
{

var xmlhttp;
var n=tip;
var de=des;
var has=hast;
var su=suc;

if(n==''){
document.getElementById("resultados").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("resultados").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","cobranzasfiltro.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n + "&r="+de +"&s="+has+"&suc="+su);
}

function guardarfiltrog1(dii,ge1,a1,no,opci,usu){	
	var xmlhttp;
	var uni=dii;
	var gest1=ge1;
	var are1=a1;
	var nom=no;
	var op=opci;
	var us=usu;

	if(n==''){
		document.getElementById(uni).innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(uni).innerHTML=xmlhttp.responseText;
		}
	}

	for(var n=0;n<1;n++){
		xmlhttp.open("POST","gcobranzasguardar.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+uni+"&ges="+gest1+"&ar="+are1+"&nomb="+nom+"&opc="+op+"&usu="+us);
	}
}

function consuciudades(tip)
{

var xmlhttp;
var n=tip;

if(n==''){
document.getElementById("ciudades").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("ciudades").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","registronotif_consultaciu.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);
}

function consuparroquias(tip)
{

var xmlhttp;
var n=tip;

if(n==''){
document.getElementById("parroquias").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("parroquias").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","registronotif_consultaparr.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);
}
function notifconsulta(provi,ciud,parr,des,has,suc)
{	
var xmlhttp;
var p=provi;
var c=ciud;
var pa=parr;
var d=des;
var h=has;
var s=suc;

if(n==''){
document.getElementById("resultados_notif").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("resultados_notif").innerHTML=xmlhttp.responseText;
}
}
for(var n=0;n<1;n++)
{
xmlhttp.open("POST","notificaciones_filtro.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("prov="+p +"&ciu="+c+"&par="+pa+"&de="+des+"&ha="+has+"&su="+suc);
}
}

function consunotif(provi,ciud,parr,des,has,suc)
{	
var xmlhttp;
var p=provi;
var c=ciud;
var pa=parr;
var d=des;
var h=has;
var s=suc;

if(n==''){
document.getElementById("resultados_notif").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("resultados_notif").innerHTML=xmlhttp.responseText;
}
}
for(var n=0;n<1;n++)
{
xmlhttp.open("POST","registronotif_filtro.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("prov="+p +"&ciu="+c+"&par="+pa+"&de="+des+"&ha="+has+"&su="+suc);
}
}

function consufiltronotif(provi,ciud,parr,des,has,suc)
{	
var xmlhttp;
var p=provi;
var c=ciud;
var pa=parr;
var d=des;
var h=has;
var s=suc;

if(n==''){
document.getElementById("resultados_notif").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("resultados_notif").innerHTML=xmlhttp.responseText;
}
}
for(var n=0;n<1;n++)
{
xmlhttp.open("POST","registronotif_filtro.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("prov="+p +"&ciu="+c+"&par="+pa+"&de="+d+"&ha="+h+"&su="+s);
}
}

function guardarimpr(id){
	var xmlhttp;
	var idd=id;
	if(n==''){
		document.getElementById("resultados_notif").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("resultados_notif").innerHTML=xmlhttp.responseText;
		}
	}

	for(var n=0;n<1;n++){
		xmlhttp.open("POST","registronotif_guardaimpre.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+idd);
	}
}

function guardarimprCobros(id){
	var xmlhttp;
	var idd=id;
	if(n==''){
		document.getElementById("resultados_notif").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("resultados_notif").innerHTML=xmlhttp.responseText;
		}
	}

	for(var n=0;n<1;n++){
		xmlhttp.open("POST","registronotif_guardaimprecobros.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+idd);
	}
}

function guardarnotif(g1,g2,g3,o1,o2,o3,i,op){	
	var xmlhttp;
	var idd=i;
	var ge1=g1;
	var ge2=g2;
	var ge3=g3;
	var a1=o1;
	var a2=o2;
	var a3=o2;
	var opc=op;
	if(n==''){
		document.getElementById("resultados_notif").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("resultados_notif").innerHTML=xmlhttp.responseText;
		}
	}

	for(var n=0;n<1;n++){
		xmlhttp.open("POST","notificaciones_guardar.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+idd +"&g1="+ge1+"&g2="+ge2+"&g3="+ge3+"&a1="+a1+"&a2="+a2+"&a3="+a3+"&op="+opc);
	}
}

function guardarnotifcobros(g1,g2,g3,o1,o2,o3,i,op){	
	var xmlhttp;
	var idd=i;
	var ge1=g1;
	var ge2=g2;
	var ge3=g3;
	var a1=o1;
	var a2=o2;
	var a3=o2;
	var opc=op;
	if(n==''){
		document.getElementById("resultados_notif").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("resultados_notif").innerHTML=xmlhttp.responseText;
		}
	}

	for(var n=0;n<1;n++){
		xmlhttp.open("POST","notificaciones_guardar_cobro.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+idd +"&g1="+ge1+"&g2="+ge2+"&g3="+ge3+"&a1="+a1+"&a2="+a2+"&a3="+a3+"&op="+opc);
	}
}

function bitacoraconsu()
{
var xmlhttp;

var n=document.getElementById('idusuario').value;

if(n==''){
document.getElementById("clientes").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("clientes").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","busquedabitacora.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);
}

function bitacoraconsuci()
{
var xmlhttp;
var n=document.getElementById('ciusuario').value;

if(n==''){
document.getElementById("clientes").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("clientes").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","busquedabitacoraci.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("a="+n);
}

function interesgenerado(id){	
	var xmlhttp;
	var idd=id;
	if(n==''){
		document.getElementById("clientes").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("clientes").innerHTML=xmlhttp.responseText;
		}
	}

	for(var n=0;n<1;n++){
		xmlhttp.open("POST","bitacora_guadar.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+idd);
	}
}

function interesgeneradocobro(id){	
	var xmlhttp;
	var idd=id;
	if(n==''){
		document.getElementById("clientes").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("clientes").innerHTML=xmlhttp.responseText;
		}
	}

	for(var n=0;n<1;n++){
		xmlhttp.open("POST","bitacora_guadar_cobro.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+idd);
	}
}

function guardarbitacora(id,interes,cobrado,deuda,conclu){	
	var xmlhttp;
	var idd=id;
	var inte=interes;
	var cob=cobrado;
	var deu=deuda;
	var con=conclu;
	if(n==''){
		document.getElementById("clientes").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("clientes").innerHTML=xmlhttp.responseText;
		}
	}

	for(var n=0;n<1;n++){
		xmlhttp.open("POST","bguardar.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+idd +"&inter="+inte+"&cobra="+cob+"&deud="+deu+"&co="+con);
	}
}

function guardarbitacoracobros(id,interes,cobrado,deuda,conclu){	
	var xmlhttp;
	var idd=id;
	var inte=interes;
	var cob=cobrado;
	var deu=deuda;
	var con=conclu;
	if(n==''){
		document.getElementById("clientes").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("clientes").innerHTML=xmlhttp.responseText;
		}
	}

	for(var n=0;n<1;n++){
		xmlhttp.open("POST","bguardarcobros.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+idd +"&inter="+inte+"&cobra="+cob+"&deud="+deu+"&co="+con);
	}
}

function reactivarcliente(id)
{	
var xmlhttp;
var idd=id;
if(n==''){
document.getElementById("clientes").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("clientes").innerHTML=xmlhttp.responseText;
}
}
for(var n=0;n<1;n++)
{
xmlhttp.open("POST","reactivarguardar.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("id="+idd);
}
}

function reactivacionconsu()
{
var xmlhttp;

var n=document.getElementById('idusuario').value;

if(n==''){
document.getElementById("clientes").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("clientes").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","reactivacionebusqueda.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);
}

function reactivacionconsuci()
{
var xmlhttp;
var n=document.getElementById('ciusuario').value;

if(n==''){
document.getElementById("clientes").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("clientes").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","reactivacionebusquedaci.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("a="+n);
}

function notifiltrousu()
{
var xmlhttp;

var n=document.getElementById('idusuario').value;

if(n==''){
document.getElementById("resultados_notif").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("resultados_notif").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","notificaciones_filtrousu.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);
}

function notifiltrousuci()
{
var xmlhttp;
var n=document.getElementById('ciusuario').value;

if(n==''){
document.getElementById("resultados_notif").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("resultados_notif").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","notificaciones_filtroci.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);
}

function consufiltronotifusu(){
	var xmlhttp;
	var n=document.getElementById('idusuario').value;

	if(n==''){
		document.getElementById("resultados_notif").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("resultados_notif").innerHTML=xmlhttp.responseText;
		}
	}

	xmlhttp.open("POST","registronotif_filtroconsu.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("q="+n);
}

function consufiltronotifci()
{
var xmlhttp;
var n=document.getElementById('ciusuario').value;

if(n==''){
document.getElementById("resultados_notif").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("resultados_notif").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","registronotif_filtroconsuci.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);
}

function generar(des,has){	
	var xmlhttp;
	var d=des;
	var h=has;
	if(n==''){
		document.getElementById("resultados").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("resultados").innerHTML=xmlhttp.responseText;
		}
	}

	for(var n=0;n<1;n++){
		xmlhttp.open("POST","reportecobranza.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("de="+d +"&ha="+h);
	}
}


function generarjuridico(des,has){	
	var xmlhttp;
	var d=des;
	var h=has;
	if(n==''){
		document.getElementById("resultados").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("resultados").innerHTML=xmlhttp.responseText;
		}
	}

	for(var n=0;n<1;n++){
		xmlhttp.open("POST","reportecobranzajuridico.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("de="+d +"&ha="+h);
	}
}

function generarno(des,has)
{	
var xmlhttp;
var d=des;
var h=has;
if(n==''){
document.getElementById("resultados").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("resultados").innerHTML=xmlhttp.responseText;
}
}
for(var n=0;n<1;n++)
{
xmlhttp.open("POST","reportenotificaciones.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("de="+d +"&ha="+h);
}
}