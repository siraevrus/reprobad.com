(() => {
  function initMobileSearch() {
    const buttons = document.querySelectorAll('.mobile-search-button');
    if (!buttons.length) return;

    let ignoreOutsideClickUntil = 0;

    function getSearchForm(button) {
      const head = button.closest('.items-head');
      return head ? head.querySelector('.search') : document.querySelector('.items-head .search');
    }

    function getMobileButton(form) {
      const head = form.closest('.items-head');
      return head ? head.querySelector('.mobile-search-button') : null;
    }

    function syncMobileButtonVisibility(form) {
      const button = getMobileButton(form);
      const input = form.querySelector('.search-input');
      if (!button || !input) return;

      // Когда в поле есть текст, появляется submit «—>» — прячем плавающую иконку, чтобы не накладывалась
      button.classList.toggle('is-hidden', input.value.trim() !== '');
    }

    function openSearch(form) {
      form.classList.add('mobile-search-active');
      form.style.removeProperty('display');
      syncMobileButtonVisibility(form);
      const input = form.querySelector('.search-input');
      if (input) {
        setTimeout(() => input.focus(), 50);
      }
    }

    function closeSearch(form) {
      form.classList.remove('mobile-search-active');
      form.style.removeProperty('display');
      syncMobileButtonVisibility(form);
    }

    function toggleSearch(form) {
      ignoreOutsideClickUntil = Date.now() + 300;
      if (form.classList.contains('mobile-search-active')) {
        closeSearch(form);
      } else {
        openSearch(form);
      }
    }

    buttons.forEach((button) => {
      button.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();

        const form = getSearchForm(button);
        if (!form) return;

        toggleSearch(form);
      });
    });

    document.querySelectorAll('.items-head .search').forEach((form) => {
      const input = form.querySelector('.search-input');
      if (!input) return;

      if (input.value.trim() !== '') {
        form.classList.add('mobile-search-active');
      }

      syncMobileButtonVisibility(form);

      input.addEventListener('input', () => syncMobileButtonVisibility(form));
      input.addEventListener('change', () => syncMobileButtonVisibility(form));
    });

    // Закрытие по клику вне формы/кнопки
    document.addEventListener('click', (event) => {
      if (Date.now() < ignoreOutsideClickUntil) return;

      const target = event.target;
      if (!(target instanceof Element)) return;
      if (target.closest('.search') || target.closest('.mobile-search-button')) return;

      document.querySelectorAll('.search.mobile-search-active').forEach(closeSearch);
    });
  }

  function init() {
    document.querySelectorAll('.bad-wrap').forEach((bad) => {
      const button = bad.querySelector('.bad-close');
      if (!button) return;

      function close() {
        bad.style.position = 'absolute';
        button.remove();
      }

      if (sessionStorage.getItem('bad-closed')) {
        close();
      }

      button.addEventListener(
        'pointerup',
        (event) => {
          event.preventDefault();
          close();
          sessionStorage.setItem('bad-closed', true);
        },
        true
      );

      bad.style.visibility = 'visible';
    });

    initMobileSearch();

    const cookiesBanner = document.querySelector('.cookies-banner');
    if (cookiesBanner) {
      if (!localStorage.getItem('cookies-accepted')) {
        cookiesBanner.style.display = 'block';
        const acceptCookies = cookiesBanner.querySelector('.accept-cookies');
        if (acceptCookies) {
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

  if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      init();
    });
  } else {
    init();
  }
})();
