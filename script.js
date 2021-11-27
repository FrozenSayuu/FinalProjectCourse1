let galarray = [];
let descarray = [];
let titlearray = [];
let lastimgopened;
const KEYCODE = {ESC: 27};
let previousActiveElement;
const exbtn = document.querySelector('.exbtn');
const dialog = document.querySelector('.dialog');
const div = document.querySelector('.pic-content');
const dialogimg = dialog.querySelector('.dialog__img');
const dialogtext = dialog.querySelector('.dialog__text');
const dialogmask = dialog.querySelector('.dialog__mask');
const dialogtitle = dialog.querySelector('.dialog__title');
const dialogwindow = dialog.querySelector('.dialog__window');

fetch("./../images.json")
    .then((response) => response.json())

.then((data) => 
{
   let imageData = data;

    imageData.forEach(images =>
        {
            galarray.push(images.url);
            titlearray.push(images.title);
            descarray.push(images.description);
            console.log(galarray);
        });

    imageData.forEach((image) =>
    {
        div.innerHTML += `<div class="gal"> <h2>${image.title}</h2> <img class=${image.class} id=${image.id} src="`+ image.url +`"/> <p>${image.description}</p> </div>`;
    });

    let galimg = document.querySelectorAll('.galimg');

    if(galimg)
    {
        galimg.forEach(function(img, index)
        {
            img.onclick = function()
            {   
                lastimgopened = index;
                let i = lastimgopened;
                openDialog();

                let showdesc = document.createElement("p");
                let showimg = document.createElement("img");
                let showtitle = document.createElement("h2");

                showdesc.setAttribute("class", "popuptext");
                showdesc.setAttribute("id", "current-text");

                showimg.setAttribute("class", "popupimg");
                showimg.setAttribute("id", "current-img");

                showtitle.setAttribute("class", "popuptitle");
                showtitle.setAttribute("id", "current-title");

                dialogtext.appendChild(showdesc);
                dialogimg.appendChild(showimg);
                dialogtitle.appendChild(showtitle);
                
                showdesc.innerHTML = descarray[i];
                showimg.setAttribute("src", "../img/" + galarray[i]);
                showtitle.innerHTML = titlearray[i];

                showimg.onload = function()
                {
                    let prevbtn = document.createElement('button');
                    let prevbtntext = document.createTextNode("<");
                    prevbtn.appendChild(prevbtntext);
                    dialogwindow.appendChild(prevbtn);
                    prevbtn.setAttribute("class", "prevbtn");
                    prevbtn.setAttribute("onclick", "changeImg(0)");
                    
                    let nextbtn = document.createElement('button');
                    let nextbtntext = document.createTextNode(">");
                    nextbtn.appendChild(nextbtntext);
                    dialogwindow.appendChild(nextbtn);
                    nextbtn.setAttribute("class", "nextbtn");
                    nextbtn.setAttribute("onclick", "changeImg(1)");
                }
            }
        });
    }
});

function openDialog()
{
    previousActiveElement = document.activeElement;
    
    dialog.classList.add('opened');

    dialogmask.addEventListener('click', closeDialog);
    exbtn.addEventListener('click', closeDialog);
    document.addEventListener('keydown', checkCloseDialog);

    dialog.querySelector('.exbtn').focus();
}

function changeImg(changeslide)
{
    document.querySelector("#current-img").remove();
    document.querySelector("#current-text").remove();
    document.querySelector("#current-title").remove();

    let newdesc = document.createElement("p");
    let newimg = document.createElement("img");
    let newtitle = document.createElement("h2");

    dialogtext.appendChild(newdesc);
    dialogimg.appendChild(newimg);
    dialogtitle.appendChild(newtitle);

    let activeslide;

    if(changeslide === 1)
    {
        activeslide = lastimgopened + 1;

        if(activeslide > 7)
        {
            activeslide = 0;
            console.log(activeslide);
        }
    }
    else if(changeslide === 0)
    {
        activeslide = lastimgopened - 1;
        if(activeslide < 0)
        {
            activeslide = 7;
            console.log(activeslide);
        }
    }

    i = activeslide;
    lastimgopened = activeslide;

    newimg.setAttribute("src", "../img/img" + activeslide + ".jpg");
    newimg.setAttribute("id", "current-img");
    newimg.setAttribute("class", "popupimg");

    newdesc.innerHTML = `<p>${descarray[activeslide]}</p>`;
    newdesc.setAttribute("class", "popuptext");
    newdesc.setAttribute("id", "current-text");

    newtitle.setAttribute("class", "popuptitle");
    newtitle.setAttribute("id", "current-title");
    newtitle.innerHTML = `<h2>${titlearray[activeslide]}</h2>`;

    lastimgopened = activeslide;
}

function checkCloseDialog(press)
{
    if(press.keyCode === KEYCODE.ESC)
    closeDialog();
}

function closeDialog()
{
    dialogmask.removeEventListener('click', closeDialog);
    exbtn.removeEventListener('click', closeDialog);
    document.removeEventListener('keydown', checkCloseDialog);
    document.querySelector(".prevbtn").remove();
    document.querySelector(".nextbtn").remove();

    dialogtitle.innerHTML = "";
    dialogtext.innerHTML = "";
    dialogimg.innerHTML = "";

    dialog.classList.remove('opened');
    previousActiveElement.focus();
}

/*let product = [{
    name: "banan",
}, ];
localStorage.setItem("key", JSON.stringify(product));

let otherproduct = JSON.parse(localStorage.getItem("product"));*/
