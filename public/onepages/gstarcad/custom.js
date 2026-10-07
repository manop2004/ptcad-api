
if ('loading' in HTMLImageElement.prototype) {
    const images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(img => {
      img.src = img.dataset.src;
    });
} else {
    // Dynamically import the LazySizes library
    const script = document.createElement('script');
    script.src =
      'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.2/lazysizes.min.js';
    document.body.appendChild(script);
}


function clickHide() {

    var company = document.getElementById("hd-show-pid");
    var company2 = document.getElementById("hd-show-pid-w");

    if(company != null){
        if (company.style.display === "block") {
            company.style.display = "none";
            company2.style.display = "block";
        } else {
            company.style.display = "block";
            company2.style.display = "none";
        }
    }

}

function loadding() {

    var element = document.getElementById("displayLoagging");
    element.classList.remove("display-none");

}
