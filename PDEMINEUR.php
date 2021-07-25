
<script type="text/javascript">

document.addEventListener (
  'DOMContentLoaded', () => {

var first_click = true

const jeu = document.querySelector('.jeu')

var largeur = 10

var carres = []

var nbrbomb = 10

const flagsLeft = document.querySelector('#flags-left')

const result = document.querySelector('#result')

var flags = 0

var GameOver = false



var sp = document.getElementsByTagName("span");
var btn_start=document.getElementById("start");
var btn_stop=document.getElementById("stop");
var t;
var ms=0,s=0;
   

  function start(){
   t =setInterval(update_chrono,1000);
  
  }
  function update_chrono(){
    s+=1;  
       sp[0].innerHTML=s+" s";
  }
  
  function stop(){
    clearInterval(t);
    
  }
  function reset(){
   clearInterval(t);
    s=0,mn=0;
       sp[0].innerHTML=s+" s";

      }





function melangetab(array) {
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }
}

function creationjeu() {


 const bombs = Array(nbrbomb).fill('bomb')
 const nobombs = Array(largeur*largeur - nbrbomb).fill('vide')
 const tabjeu =  nobombs.concat(bombs)
 melangetab(tabjeu)
  start()


for (var i = 0; i < largeur*largeur; i++ ) {
	const carre = document.createElement('div')
	carre.setAttribute('id', i)
	carre.classList.add(tabjeu[i])
    jeu.appendChild(carre)
    carres.push(carre)

carre.addEventListener('click', function(e) {
        clickgauche(carre)
     })

carre.oncontextmenu = function(e) {
        e.preventDefault()
        addFlag(carre) }
carre.onmouseover = function(e) {
        over_on_case(carre)      }
carre.onmouseout = function(e) {
        out_on_case(carre)       }

   
	}
}

function over_on_case(carre){
  carre.style.border = "1px #FFFFFF inset";  
  
}
function out_on_case(carre){
  carre.style.border = "1px solid #9c998d";  
  
}

function nbrb()
{
	for (let i = 0; i < largeur*largeur; i++) {
    var sumbomb=0;
    const maxgauche = (i % largeur === 0)
    const maxdroite = (i % largeur === largeur -1)

if (carres[i].classList.contains('vide')) {

    if (i > 0 && !maxgauche && carres[i -1].classList.contains('bomb'))
    {
        sumbomb++;
    }
    if (i < 98 && !maxdroite && carres[i +1].classList.contains('bomb'))
    {
        sumbomb++;
    }
    if (i > 11 && !maxgauche && carres[i -1 -largeur].classList.contains('bomb'))
    {
        sumbomb++;
    }
    if (i > 9 && !maxdroite  && carres[i +1 -largeur].classList.contains('bomb'))
    {
        sumbomb++;
    }
    if (i < 90 && !maxgauche && carres[i -1 +largeur].classList.contains('bomb'))
    {
        sumbomb++;
    }
    if (i < 88 && !maxdroite && carres[i +1 +largeur].classList.contains('bomb'))
    {
        sumbomb++;
    }
    if (i > 10 && carres[i -largeur].classList.contains('bomb'))
    {
        sumbomb++;
    }
    if (i < 89 && carres[i +largeur].classList.contains('bomb'))
    {
        sumbomb++;

    }
    }
        carres[i].setAttribute('data', sumbomb)
    }}

creationjeu()
nbrb()



  function addFlag(carre) {
    if (GameOver) return
    if (!carre.classList.contains('checked') && (flags < nbrbomb)) {
      if (!carre.classList.contains('flag')) {
        carre.classList.add('flag')
        carre.innerHTML = ' 🚩'
        flags ++
        flagsLeft.innerHTML = nbrbomb- flags
        checkForWin()
      } else {
        carre.classList.remove('flag')
        carre.innerHTML = ''
        flags --
        flagsLeft.innerHTML = nbrbomb- flags
      }
    }
  }

function clickgauche(carre) {
        var id1 = carre.id
    if (GameOver) return
    if (carre.classList.contains('checked') || carre.classList.contains('flag')) return
    if (carre.classList.contains('bomb')) {
      gameOver(carre)
    } else {
      var num = carre.getAttribute('data')
      if (num !=0) {
        carre.classList.add('checked')
        if (num == 1) carre.classList.add('one')
        if (num == 2) carre.classList.add('two')
        if (num == 3) carre.classList.add('three')
        if (num == 4) carre.classList.add('four')
        carre.innerHTML = num
        return
      }
      checkcarre(carre, id1)
    }
    carre.classList.add('checked')
  }

		


  //add Flag with right click
  function clickdroite(carre) {

    if (GameOver) return
    if (!carre.classList.contains('checked') && (flags < nbrbomb)) {
      if (!carre.classList.contains('flag')) {
        carre.classList.add('flag')
        carre.innerHTML = ' 🚩'
        flags ++
        flagsLeft.innerHTML = nbrbomb- flags
        checkForWin()
      } else {
        carre.classList.remove('flag')
        carre.innerHTML = ''
        flags --
        flagsLeft.innerHTML = nbrbomb- flags
      }
    }
  }


  //check neighboring squares once square is clicked
  function checkcarre(carre, id1) {
    const maxgauche = (id1 % largeur === 0)
    const maxdroite = (id1 % largeur === largeur -1)
    setTimeout(() => {
      if (id1 > 0 && !maxgauche) {
        const id2 = carres[parseInt(id1) -1].id
        const nvcarre = document.getElementById(id2)
        clickgauche(nvcarre)
      }
      if (id1 > 9 && !maxdroite) {
        const id2 = carres[parseInt(id1) +1 -largeur].id
        const nvcarre = document.getElementById(id2)
        clickgauche(nvcarre)
      }
      if (id1 > 10) {
        const id2 = carres[parseInt(id1 -largeur)].id
        const nvcarre = document.getElementById(id2)
        clickgauche(nvcarre)
      }
      if (id1 > 11 && !maxgauche) {
        const id2 = carres[parseInt(id1) -1 -largeur].id
        const nvcarre = document.getElementById(id2)
        clickgauche(nvcarre)
      }
      if (id1 < 98 && !maxdroite) {
        const id2 = carres[parseInt(id1) +1].id
        const nvcarre = document.getElementById(id2)
        clickgauche(nvcarre)
      }
      if (id1 < 90 && !maxgauche) {
        const id2 = carres[parseInt(id1) -1 +largeur].id
        const nvcarre = document.getElementById(id2)
        clickgauche(nvcarre)
      }
      if (id1 < 88 && !maxdroite) {
        const id2 = carres[parseInt(id1) +1 +largeur].id
        const nvcarre = document.getElementById(id2)
        clickgauche(nvcarre)
      }
      if (id1 < 89) {
        const id2 = carres[parseInt(id1) +largeur].id
        const nvcarre = document.getElementById(id2)
        clickgauche(nvcarre)
      }
    }, 10)
  }

  //game over
  function gameOver(carre) {
    result.innerHTML = 'Game Over. Veuillez lancer une nouvelle partie.(temps écoulé : '+s+' secondes).'
   GameOver = true
   stop()
    //show ALL the bombs
    carres.forEach(carre => {
      if (carre.classList.contains('bomb')) {
        carre.innerHTML = '💣'
        carre.classList.remove('bomb')
        carre.classList.add('checked')
      }
    })

  }
  function checkForWin() {
  let matches = 0

    for (let i = 0; i < carres.length; i++) {
      if (carres[i].classList.contains('flag') && carres[i].classList.contains('bomb')) {
        matches ++
      }
      if (matches === nbrbomb) {
        result.innerHTML = "Félicitation vous avez trouvé toutes les mines ! (temps écoulé : "+s+" secondes)."
        GameOver = true

      }}}
})
</script>