const backSlider = document.getElementById('back-slider');

var slideArr = [
    'css/head-back.png',
    'css/head-back1.png',
    'css/head-back2.png',
    'css/head-back3.png'
]

document.addEventListener("DOMContentLoaded", function () {
    const slide = document.querySelector("#back-slider");
    let currentIndex = 0;
  
    function showSlide(i) {
        // for(i = 0; i < slideArr.length; i++){
        //     slide.style.backgroundImage = `url(` + slideArr[i] + `)`;
        //     //slide.style.opacity = i === index ? 1 : 0;

        // }
        slide.style.backgroundImage = `url(` + slideArr[i] + `)`;
       
    }
  
    function nextSlide() {
      currentIndex++; 
      if(currentIndex >= slideArr.length){
        currentIndex = 0;
      }
      showSlide(currentIndex);
    }
  
    setInterval(nextSlide, 5000); // Автоматическая смена слайдов каждые 5 секунд
    showSlide(currentIndex); // Показать первый слайд при загрузке страницы
  });
    

// const appealForm = document.getElementById('appeal-form');

// document.getElementById("appeal-button").addEventListener("click", function(){
//   console.log("q")
//   appealForm.style.display = "flex";
// })
