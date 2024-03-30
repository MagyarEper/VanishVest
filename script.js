let isOpen = false;
function toggleMenu() {
    let menu = document.querySelector('.mini-menu');
    if(!isOpen) {
        menu.style.display = 'block';
        isOpen = true;
    } else {
        menu.style.display = 'none';
        isOpen = false;
    }
  }

  
  
  window.addEventListener('load', function() {
    let banner = document.getElementById('banner');

    function setBanner() {
        if (window.matchMedia('(max-width: 1100px)').matches) {
            banner.src = './Images/BannerImage2.png';
        }else {
            banner.src = './Images/bannerImage.png';
        }
    }

    setBanner();
    window.addEventListener('resize', setBanner);
  });
  