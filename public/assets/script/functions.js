const getFormRequestResponse = async (form, options={"method": "POST"}) => {
    let formData = new FormData(form);

    if (options.format == "json") {
        formData = JSON.stringify(Object.fromEntries(formData));
    }

    options = Object.assign(options, {"body": formData});
    let response = await fetch(form.action, options);

    return response;
};

const parseRequestResult = async (response, format="text") => {
    let result = "";
    if (format == "text") result = await response.text();
    else if (format == "json") result = await response.json();

    return result;
};

const getRequestError = async (response, format="text") => {
    if (!response.ok) return await parseRequestResult(response, format);
}

const getRequestErrorOrRedirect = async (response, format="text") => {
    if (!response.redirected) return await getRequestError(response, format);

    window.location.href = response.url;
}

const setUriParam = (key, value, url=window.location.href) => {
    let urlObject = new URL(url);
    urlObject.searchParams.set(key, value);

    window.location.href = urlObject.href;
}

const displaySwitch = (element, switchFrom, switchTo) => {
    let display = window.getComputedStyle(element)["display"];
    element.style.display = display == switchFrom ? switchTo : switchFrom;
};

const execMatch = (item1, item2, funcMatch) => item1 == item2 ? funcMatch() : null;

const execUrlPathMatch = (url, funcMatch) => {
    let urlObject = new URL(url);
    execMatch(urlObject.pathname, window.location.pathname, funcMatch);
}

const usePair = (lib, pair) => {
    let pairParsed = parsePair(pair);
    return lib[pairParsed[0]][pairParsed[1]] ?
           lib[pairParsed[0]][pairParsed[1]]() : lib[pairParsed[0]](pairParsed[1]);
};

const getPair = (text, pairName) => {
    let pattern = pairName + "{[a-zA-Z0-9-_]+:[a-zA-Z0-9-_]+}";
    let regex = new RegExp(pattern, "g");
    let result = text.match(regex);

    return result ? result[0] : "";
};

const parsePair = (pair) => {
    let regex = /[a-zA-Z0-9-_]+:[a-zA-Z0-9-_]+/;

    return pair.match(regex)[0].split(":");
};

const setTextPairValue = (text, pair, newPairValue) => {
    let regex = /:[a-zA-Z0-9-_]+/;
    let newPair = pair.replace(regex, ":" + newPairValue);

    return text.replace(pair, newPair);
};

const isChecked = (pair) => parsePair(pair)[1] == 1 ? true : false;

const useCheck = (pair, func_checked, funcUnchecked) =>
    isChecked(pair) ? funcChecked() : funcUnchecked();

const switchCheck = (text, pair, funcChecked=()=>{}, funcUnchecked=()=>{}) => {
    if (isChecked(pair)) {
        funcUnchecked();

        return setTextPairValue(text, pair, 0);
    }

    funcChecked();

    return setTextPairValue(text, pair, 1);
};
