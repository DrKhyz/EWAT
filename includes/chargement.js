function timediff()
{
       //temp de fin
        fin = (new Date()).getTime();
        // difference entre la fin et le début
        secondes = (fin-debut)/1000;
        // met le résultat là où le ID de la balise HTML est chargement
        document.getElementById("chargement").innerHTML = "Display in " + secondes + " sec.";
}
function timeStamp()
{
  return ((new Date()).getTime());
}