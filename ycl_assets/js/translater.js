/**
 * Initialize page
 */
$(document).ready(async function() {

    try {
        // stop initializing for login pages
        if ($('#languageSelect').length === 0) {
            return false;
        }

        $('#languageSelect').css('cursor', 'pointer');
        
        const translatorArr = await initializeTranslatorArr();
    
        initializeLanguageSettings(false, translatorArr);
    
        $('table thead th').on('click', function(event) {
            
            let eventType = event.target.type;
            if(eventType == "text") {
                translateTable();
            } else {
                initializeLanguageSettings(false, translatorArr);
            }
        });

        $('#languageSelect').on("change", function() {
            initializeLanguageSettings(true, translatorArr);
        });
    } catch (error) {
        console.log(error);
    }
});

async function initializeLanguageSettings (isChange = false,  translatorArr = []) {
    
    try {

        disableUserInput();
        const userLanguage = isChange ? $("#languageSelect").val() : translatorArr.lang;
        
        /**
         * Page Translate
         */
        if(isChange) {

            translatorArr.lang = $("#languageSelect").val();
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
            success: async function(response) {
                if(response) {
                    let language = response[0].language;
                    if($('#languageSelect')) {
                        $('#languageSelect').val(language);
                    }
                    resolve(language);
                } else {
                    try {
                        disableUserInput();
                        const language = await updateUserLanguage();
                        resolve(language);
                    } catch (error) {
                        console.log(error);
                        reject(error);
                    } finally {
                        closeSwal();
                    }
                }
            },
            error: function() {
                const errorMessage = 'Failed to fetch language';
                reject(errorMessage);
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

        return new TranslationManager(arrData, lang);
    } catch (error) {
        console.log(error);
    }
}

function disableUserInput() {
    $('body').css('pointer-events', 'none');
    $('body').attr('style', 'cursor: not-allowed !important');

    const overlay = document.createElement('div');
    overlay.id = 'custom-overlay';
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    overlay.style.zIndex = '9999';

    // Append the overlay to the body
    document.body.appendChild(overlay);

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

    const customOverlay = document.getElementById('custom-overlay');
    if (customOverlay) {
        document.body.removeChild(customOverlay);
    }

    Swal.close();
}

async function initializeTranslatorArr() {
    try {
        const [lang, arrData] = await Promise.all([
            initializeLanguage(),
            fetchAllText()
        ]);
       
        TranslationManager.setUserLanguage(lang);
        TranslationManager.setArrData(arrData);

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
async function updateUserLanguage(language = "english") {
    try {
        const response = await $.ajax({
            url: project_url + "/translator/updateUserLanguage",
            data: { selectedLanguage: language },
            dataType: 'JSON',
            method: 'POST'
        });

        if (response.bool) {
            console.log(response.msg);
            $('#languageSelect').val(language);

        } else {
            console.log("Error: " + response.msg);
        }

        return language;
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
            console.log(error);
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

            if (textNode.parentNode && textNode.parentNode.nodeType === Node.ELEMENT_NODE && textNode.parentNode.tagName.toLowerCase() === 'script') {
                continue;
            }

            const replacedText = text.replace(new RegExp(escapedSearchWord, 'g'), replacementWord);
            textNode.textContent = replacedText;

            // replaceBugWord("Account Informaciónrmation", "Información de la cuenta");
            if(TranslationManager.userLanguage == "english") {
                replaceBugWord("Perareal Information", "Personal Information");
                replaceBugWord("Info de la cuenta", "Account Information");
                replaceBugWord("Select a perare to chat", "Select person to chat");
            }
            if(TranslationManager.userLanguage == "spanish") {
                replaceBugWord("Personal Informaciónrmation", "Informacion personal");
                replaceBugWord("Account Informaciónrmation", "Información de la cuenta");
            }

            function replaceBugWord(bugWord, newWord) {
                if(replacedText.includes(bugWord)) {
                    const escapeBugword = escapeRegExp(bugWord);
                    const customText = text.replace(new RegExp(escapeBugword, 'g'), newWord);
                    textNode.textContent = customText;
                }
            }
        }
    }
}


function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}


/**
 * popup translator
 */
function translateToast(translationObj) {
    return new Promise(async (resolve, reject) => {
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
            resolve();
        } catch (error) {
            reject(error);
        }
    });
}
		
function translateSwals(translationObj) {
    return new Promise(async (resolve, reject) => {
        try {
            
            // Translator for swals elements
            const translator = translationObj;
            const selectors = [
                '.swal2-title',
                '.swal2-text',
                '.swal2-confirm',
                '.swal2-cancel',
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

            // Translator for custom swal html e.g => html: `sample html <p>bold text<p>`
            const swalHtmlElement = document.querySelector('.swal2-html-container');
            if (swalHtmlElement) {
                
                let swalHTML = swalHtmlElement.textContent;

                const arrData = translator.arrData;
                
                arrData.forEach((text) => {
                    let toTranslate = (translator.userLanguage == "english") ?  text.spanish_text : text.english_text;
                    
                    let translatedText = translator.translate(toTranslate);
                    const escapedText = toTranslate.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');

                    // Use the escaped pattern in the regular expression with global flag
                    const regex = new RegExp(escapedText, 'g');
                    swalHTML = swalHTML.replace(regex, translatedText);
                });
            
                swalHtmlElement.textContent = swalHTML;

            }

            resolve();

        } catch (error) {
            reject(error);
        }
    });
}

function translateTable() {
    try {
        
        // Translator for swals elements
        const selectors = [
            '.dataTables_info',
            '.paginate_button a',
            '.dataTables_empty'
        ];

        selectors.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach((element) => {
                
                let swalHTML = element.textContent;

                const arrData = TranslationManager.arrData;
                
                arrData.forEach((text) => {
                    let toTranslate = (TranslationManager.userLanguage == "english") ?  text.spanish_text : text.english_text;
                    
                    let translatedText = TranslationManager.staticTranslate(toTranslate);
                    const escapedText = toTranslate.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');

                    // Use the escaped pattern in the regular expression with global flag
                    const regex = new RegExp(escapedText, 'g');
                    swalHTML = swalHTML.replace(regex, translatedText);
                });
            
                element.innerHTML = swalHTML;
    
            });
        });


    } catch (error) {
        console.log(error);
    }
}

async function awaitPopupTranslator(translatorArr) {
    try {
        let translationData = await createLanguageTranslator(translatorArr);
        
        addEvents();
        await Promise.all([translateSwals(translationData), translateToast(translationData)]);
    
        $(document).on('click', async function() {
            addEvents();
            await Promise.all([translateSwals(translationData), translateToast(translationData)]);
    
        });
    } catch (error) {
        console.log(error);
    }
}

function addEvents() {
    $('input[type="search"]').on('input', function() {
        $('.dataTable').on('draw.dt', translateTable);
    });
    $('input[type="text"]').on('click', translateTable);
    $('input[type="text"]').on('keyup', function(event) {
        $('.dataTable').on('draw.dt', translateTable);
    });
}