window.onload = () => {
    const barsbtn = document.getElementById('bars-btn');
    const navbar = document.querySelector('.navbar')
    barsbtn.onclick = () => {
        console.log(navbar.style.maxHeight)
        if (navbar.style.maxHeight === '100vh') {
            navbar.style.maxHeight = '0';
        }
        else {
            navbar.style.maxHeight = '100vh';
        }
    }
    console.log('actualites')
    $('.actualites-banner').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        infinite: true,
        dots: true
    });
}