const ROOT = document.documentElement;

const LIKE_IMG = {
    "checked": "/assets/img/icons/like-checked-icon.png",
    "unchecked": "/assets/img/icons/like-icon.png"
};

const MAIN_THEME_SET = {
    "dark": () => {
        ROOT.style.setProperty("--back-color-l", "hsl(0, 0%, 15%)");
        ROOT.style.setProperty("--back-color", "hsl(0, 0%, 10%)");
        ROOT.style.setProperty("--back-color-d", "hsl(0, 0%, 5%)");
        ROOT.style.setProperty("--font-color", "hsl(0, 0%, 90%)");
        ROOT.style.setProperty("--icon-invert", "invert(100%)");
    },
    "light": () => {
        ROOT.style.setProperty("--back-color-l", "hsl(0, 0%, 70%)");
        ROOT.style.setProperty("--back-color", "hsl(0, 0%, 75%)");
        ROOT.style.setProperty("--back-color-d", "hsl(0, 0%, 80%)");
        ROOT.style.setProperty("--font-color", "hsl(0, 0%, 15%)");
        ROOT.style.setProperty("--icon-invert", "none");
    }
};

const COLOR_THEME_SET = {
    "red": () => {
        ROOT.style.setProperty("--theme-color", "hsl(360, 60%, 40%)");
        ROOT.style.setProperty("--theme-color-d", "hsl(360, 60%, 25%)");
    },
    "green": () => {
        ROOT.style.setProperty("--theme-color", "hsl(90, 60%, 40%)");
        ROOT.style.setProperty("--theme-color-d", "hsl(90, 60%, 25%)");
    },
    "blue": () => {
        ROOT.style.setProperty("--theme-color", "hsl(190, 60%, 40%)");
        ROOT.style.setProperty("--theme-color-d", "hsl(190, 60%, 25%)");
    }
};

const MAIN_THEME = {
    "dark": () => {
        MAIN_THEME_SET.dark();
        localStorage.removeItem("main-theme");
    },
    "light": () => {
        MAIN_THEME_SET.light();
        localStorage.setItem("main-theme", "light");
    }
};

const COLOR_THEME = {
    "red": () => {
        COLOR_THEME_SET.red();
        localStorage.setItem("color-theme", "red");
    },
    "green": () => {
        COLOR_THEME_SET.green();
        localStorage.setItem("color-theme", "green");
    },
    "blue": () => {
        COLOR_THEME_SET.blue();
        localStorage.removeItem("color-theme");
    }
};

const SELECT_LIB = {
    "main-theme": MAIN_THEME,
    "color-theme": COLOR_THEME
};

const STORAGE_LIB = {
    "local": (item) => localStorage.getItem(item),
    "session": (item) => sessionStorage.getItem(item)
};
