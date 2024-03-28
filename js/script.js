document.addEventListener("DOMContentLoaded", async function() {
    // Выполнить запрос к PHP скрипту для получения данных из базы данных
    let res = await fetch('php/fetch_data.php');
    let posts = await res.json();

    posts = posts.reverse();

    posts.forEach((posts) => {
        posts.text = removeHashWords(posts.text);
        if(posts.photo != ""){
            document.getElementById('news-conteiner').innerHTML +=`
            <div class="news-box">
                 <img src="${posts.photo}" alt="news-photo">
                 <div class="news-text">
                    <img src="images/вк лого.svg" alt="vk-logo">
                    <p>${posts.text}</p>
                    <span>${posts.date}</span>
                </div>
    
            </div>`
        } else{
            document.getElementById('news-conteiner').innerHTML +=`
            <div class="news-box">
                 <img src="images/no_photo.svg" alt="news-photo">
                 <div class="news-text">
                    <img src="images/вк лого.svg" alt="vk-logo">
                    <p>${posts.text}</p>
                    <span>${posts.date}</span>
                </div>
    
            </div>`
        }

    });
    // console.log(posts);
});

function removeHashWords(text) {
    
    let words = text.split(/\s+/);
    
    let filteredWords = words.filter(word => !word.startsWith('#'));
    
    let result = filteredWords.join(' ');
    
    return result;
}
