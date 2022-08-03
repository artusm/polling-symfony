let mainTheme = localStorage.getItem("main-theme");
if (mainTheme) MAIN_THEME[mainTheme]();

let colorTheme = localStorage.getItem("color-theme");
if (colorTheme) COLOR_THEME[colorTheme]();
