/**
 * Initialize page
 */
$(document).ready(async function() {

    const translatorArr = await initializeTranslatorArr();

    initializeLanguageSettings(false, translatorArr);

    $('#languageSelect').css('cursor', 'pointer');

    $('table thead th').on('click', function() {
        initializeLanguageSettings(false, translatorArr);
    });

    $('#languageSelect').on("change", function() {
        initializeLanguageSettings(true, translatorArr);
    });
});

async function initializeLanguageSettings (isChange = false,  translatorArr = []) {
    
    try {
        if ($('#languageSelect').length === 0) {
            return false;
        }

        disableUserInput();
        const userLanguage = isChange ? $("#languageSelect").val() : translatorArr.lang;
        console.log("userLanguage: " , userLanguage);
        
        /**
         * Page Translate
         */
        if(isChange) {

            translatorArr.lang = userLanguage;
            await Promise.all([
                updateUserLanguage(userLanguage),
                updatePageLanguage(userLanguage),
                awaitPopupTranslator(translatorArr)
            ]);

        } else {

            if (translatorArr.lang !== "") {
                await Promise.all([
                    updatePageLanguage(userLanguage),
                    awaitPopupTranslator(translatorArr)
                ]);

            } else { console.log("There's no language.") }
           
        }

    } catch (error) {
        console.error("An error occurred:", error);
    } finally {
        console.log("Initialization success.");
        closeSwal();
    }
}

/**
 * Global Functions
 */
function fetchAllText() { 
    return new Promise((resolve, reject) => {
        $.ajax({
            url: project_url + "/translator/getTextData",
            dataType: "JSON",
            method: "POST",
            success: function(response) {
                if(response) {
                    resolve(response);
                }
                else
                {
                    const errorMessage = 'Failed to fetch language data';
                    reject(errorMessage);
                }
            }
        });
    });
}

function initializeLanguage() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: project_url + "/translator/initializeUserLanguageSetting",
            dataType: "JSON",
            method: "POST",
            success: function(response) {
                if(response) {
                    let language = response[0].language;
                    if($('#languageSelect')) {
                        $('#languageSelect').val(language);
                    }
                    resolve(language);
                }
                
            },
            error: function() {
                const errorMessage = 'Failed to fetch language';
                reject(errorMessage);
            }
        });
    });
}

async function getUserLanguageSetting() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: project_url + "/translator/initializeUserLanguageSetting",
            dataType: 'JSON',
            method: 'POST',
            success: resolve,
            error: (xhr, status, error) => {
                console.error("No response from server.");
                reject(false);
            }
        });
    });
}

async function createLanguageTranslator(translatorArr = []) {
    try {
        const lang = translatorArr.lang ? translatorArr.lang : await initializeLanguage();
        const arrData = translatorArr.arrData ? translatorArr.arrData : await fetchAllText();
        
        TranslationManager.setUserLanguage(lang);
        TranslationManager.setArrData(arrData);

        return new TranslationManager();
    } catch (error) {
        console.log(error);
    }
}

function disableUserInput() {
    $('body').css('pointer-events', 'none');
    $('body').attr('style', 'cursor: not-allowed !important');
    Swal.fire({
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
            Swal.getContainer().style.pointerEvents = 'none'; // Disable user input
        }
    });
}

function closeSwal() {
    const container = Swal.getContainer();
    if (container !== null) {
        container.style.pointerEvents = 'auto';
    }
    $('body').css('pointer-events', 'auto');
    $('body').attr('style', 'cursor: auto !important');
    Swal.close();
}

async function initializeTranslatorArr(callback = "") {
    try {
        const [lang, arrData] = await Promise.all([
            initializeLanguage(),
            fetchAllText()
        ]);
       
        return {
            lang: lang,
            arrData: arrData
        };
    } catch (error) {
        // Handle errors here
        console.error(error);
    }
}

/**
 * page translator
 */
async function updateUserLanguage(language) {
    try {
        const response = await $.ajax({
            url: project_url + "/translator/updateUserLanguage",
            data: { selectedLanguage: language },
            dataType: 'JSON',
            method: 'POST'
        });

        if (response.bool) {
            console.log("Language: " + response.msg);
        } else {
            console.log("Error: " + response.msg);
        }
    } catch (error) {
        console.error(error);
    }
}

async function updatePageLanguage(language) {
    try {
        const arrEnglishToSpanishData = await fetchAllText();
        await translateText(language, arrEnglishToSpanishData);
    } catch (error) {
        console.log(error);
    }
}


function translateText(selectedLanguage, arrData) {
    return new Promise((resolve, reject) => {
        try {
            for(let i = 0; i < arrData.length; i++){
                english_text = arrData[i].english_text;
                spanish_text = arrData[i].spanish_text;
                let isReplaced = false;
                if(selectedLanguage == "spanish" && isReplaced == false)
                {
                    isReplaced = true;
                    replaceSpecificWords(english_text, spanish_text); // searchWord, replacementWord
                }
                else if(selectedLanguage == "english" && isReplaced == false)
                {
                    isReplaced = true;
                    replaceSpecificWords(spanish_text, english_text); // searchWord, replacementWord
                }
                else
                {
                    console.log("Translation failed.");
                }
            }

            resolve ("Finish translating word by word.");
            
        } catch (error) {
            reject(`translateText: ${error}`);
        }
    });
}

function replaceSpecificWords(searchWord, replacementWord) {
    const textNodes = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null, false);

    while (textNodes.nextNode()) {
        const textNode = textNodes.currentNode;
        const text = textNode.textContent;

        // Check if the search word exists in the text content
        if (text.includes(searchWord)) {
            const escapedSearchWord = escapeRegExp(searchWord);
            if(textNode.textContent.toLowerCase() == "json(s)" || textNode.textContent.toLowerCase() == "json")
            {
                continue;
            }

            const replacedText = text.replace(new RegExp(escapedSearchWord, 'g'), replacementWord);
            textNode.textContent = replacedText;
        }
    }
}

function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}


/**
 * popup translator
 */
async function translateToast(translationObj) {
    try {
        const translator = await translationObj;
        const observer = new MutationObserver((mutationsList, observer) => {
            for (const mutation of mutationsList) {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    const addedElements = Array.from(mutation.addedNodes);
                    
                    for (const element of addedElements) {
                        if (element.classList?.contains('toast')) {
                            const toastContent = element.querySelector('.toast-message');
                            if (toastContent) {
                                toastContent.innerHTML = translator.translate(toastContent.innerHTML);
                            }
                        }
                    }
                }
            }
        });
    
        observer.observe(document.body, { childList: true, subtree: true });
    } catch (error) {
        console.log(error);
    }
}
		
async function translateSwals(translationObj) {
    try {
        
        const translator = translationObj;
    
        const selectors = [
            '.swal2-title',
            '.swal2-text',
            '.swal2-confirm',
            '.swal2-cancel',
            '.swal2-html-container',
            '.swal2-modal-content',
            '.swal2-header',
            '.swal2-subheader',
            '.swal2-image',
            '.swal2-close-button-label',
            '.swal2-button-label',
            '.swal2-loading-text',
            '.swal2-backdrop-background-color',
            '.swal2-modal-content-description',
        ];
    
        selectors.forEach((selector) => {
            const elements = document.querySelectorAll(selector);
            elements.forEach((element) => {
                element.innerHTML = translator.translate(element.innerHTML);
            });
        });
        // console.log("Swal translation has been initiated.");
    } catch (error) {
        console.log(error);
    }
}

async function awaitPopupTranslator(translatorArr) {
    let translationData = await createLanguageTranslator(translatorArr);
    await Promise.all([translateSwals(translationData), translateToast(translationData)]);

    $(document).on('click', async function() {
        await Promise.all([translateSwals(translationData), translateToast(translationData)]);
    });
}


