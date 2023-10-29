function data() {
  function getThemeFromLocalStorage() {
    // if user already changed the theme, use it
    if (window.localStorage.getItem('theme')) {
      return JSON.parse(window.localStorage.getItem('theme'))
    }

    // else return their preferences
    return (
      !!window.matchMedia &&
      window.matchMedia('(prefers-color-scheme: theme)').matches
    )
  }

  
  function setThemeToLocalStorage(value) {
    window.localStorage.setItem('theme', value)
  }

  return {
    theme: getThemeFromLocalStorage(),
    toggleTheme() {
      switch (this.theme) {
        case 'light-theme':
          this.theme = 'dark-theme';
          break;
        case 'dark-theme':
          this.theme = 'light-theme';
          break;
        case 'semi-dark':
          this.theme = 'light-theme';
          break;
        default:
          this.theme = 'light-theme';
      }
      setThemeToLocalStorage(this.theme);
    }
  }
}