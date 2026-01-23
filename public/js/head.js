(() => {
  function init() {
    document.querySelectorAll(".bad-wrap").forEach(bad => {
      const button = bad.querySelector(".bad-close");
      if(!button) return;

      function close() {
        bad.style.position = "absolute";
        button.remove();
      }

      if(sessionStorage.getItem("bad-closed")) {
        close();
      }

      button.addEventListener("pointerup", (event) => {
        event.preventDefault();
        close();
        sessionStorage.setItem("bad-closed", true);
      }, true);

      bad.style.visibility = "visible";
    });

    document.querySelectorAll('.mobile-search-button').forEach(button => button.addEventListener('pointerup', () => {
      setTimeout(() => {
        const searchInput = document.querySelector('.search-input');
        searchInput && searchInput.focus();
      }, 50);
    }));
    
    const cookiesBanner = document.querySelector('.cookies-banner');
    if(cookiesBanner) {
      if(!localStorage.getItem('cookies-accepted')) {
        cookiesBanner.style.display = 'block';
        const acceptCookies = cookiesBanner.querySelector('.accept-cookies');
        if(acceptCookies) {
          acceptCookies.addEventListener('pointerup', (event) => {
            event.preventDefault();
            localStorage.setItem('cookies-accepted', true);
            cookiesBanner.remove();
          });
        }
      } else {
        cookiesBanner.remove();
      }
    }

  }

  if (document.readyState == 'loading') { document.addEventListener('DOMContentLoaded', () => { init(); } ); } 
  else { init(); }
})();