// Global_Constants
const userLanguage = initializeLanguage();
const languageArrData = fetchAllText();


// Global Variables
// var translator;

/**************** Start : Run Logic here ****************/
/*
    Sample code to translate swal
    (async () => {
        const translator = await createLanguageTranslator();
        let sampleTitle = translator.translate("Yes!");
    })();
*/
/**************** End : Run Logic here ****************/
// Global Functions

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


// Page translators
async function updateUserLanguage(language) {
    try {
        const response = await $.ajax({
            url: project_url + "/translator/updateUserLanguage",
            data: { selectedLanguage: language },
            dataType: 'JSON',
            method: 'POST'
        });

        if (response.bool) {
            console.log(response.msg);
        } else {
            console.log("Error: " + response.msg);
        }
    } catch (error) {
        console.error(error);
    }
}

async function updatePageLanguage(language) { // comeback
    try {
        (async () => {
            const arrEnglishToSpanishData = await fetchAllText();
            await translateText(language, arrEnglishToSpanishData);
        })();
        
    } catch (error) {
        console.log(error);
    }
}

async function translateData() {
    try {
        const arrData = await fetchAllText();
        const userLanguage = await initializeLanguage();

        const translationDataObject = {
            arrData: arrData,
            userLanguage: userLanguage
        };

        return translationDataObject;

    } catch (error) {
        console.error(error);
    }
}

// get data from controller
async function initializeLanguageSettings() {
    if($('#languageSelect').length === 0) {
        return false;
    }
    await translateSwals();

    // The swal translation are need to be invoked everytime it will  be displayed
    document.addEventListener('click', async () => {
        await translateSwals();
        observeDOMChanges();
    });

    disableUserInput();

    $.ajax({
        url: project_url + "/translator/initializeUserLanguageSetting",
        dataType: 'JSON',
        method: 'POST',
        success: async function(response) {
            try {
                if (response) {
                    const language = response[0].language;
                    if (language) {
                        // console.log('Initializing :' + language);
                        if ($('#languageSelect')) {
                            $('#languageSelect').val(language);
                        }
                        console.log("language has been initialized.");
                        await updatePageLanguage(language);
                    } else {
                        console.log("There's no language.");
                    }
                } else {
                    console.log("Error response.");
                }
            } catch (error) {
                console.error("An error occurred:", error);
            } finally {
                closeSwal();
            }
        },
        error: function(xhr, status, error) {
            console.log("No response from server.");
            closeSwal();
        }
    });
}

function translateText(selectedLanguage, arrData) {
    return new Promise((resolve, reject) => {
        
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
    });
}

// page translator
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
 * Translator Other function
 */
function disableUserInput() {
    $('body').css('pointer-events', 'none');
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
    Swal.close();
}

// toast translator
function observeDOMChanges(callback) {
    createLanguageTranslator().then((translator)=>{
        const observer = new MutationObserver((mutationsList, observer) => {
            for (const mutation of mutationsList) {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    const addedElements = Array.from(mutation.addedNodes);
                    
                    for (const element of addedElements) {
                        if (element.classList?.contains('toast')) {
                            const toastContent = element.querySelector('.toast-message');
                            if (toastContent) {
                                // translating the toast
                                toastContent.innerHTML = translator.translate(toastContent.innerHTML);
                            }
                        }
                    }
                }
            }
        });
    
        observer.observe(document.body, { childList: true, subtree: true });
    });
}


/**
 * New Translation function, using Translation Manager
 */

async function getUserLanguageAndArrayData () {
    try {
        let lang = await userLanguage;
        let arr = await languageArrData;

        const resultObj = {
            userLanguage : lang,
            arrayLanguage: arr
        }
        return resultObj;
    } catch (error) {
        console.log(error);
    }
}


async function createLanguageTranslator () {
    try {
        const resultData = await getUserLanguageAndArrayData();
        const userLang = resultData.userLanguage;
        const arrData = resultData.arrayLanguage;

        return new TranslationManager(arrData, userLang);
    } catch (error) {
        console.log(error);
    }
}


/**
 * Testing Swal translation
 */

		
async function translateSwals() {
    try {
        
        const translator = await createLanguageTranslator();
    
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
            '.toast-message',
        ];
    
        const toastSelector = [
            '.toast-message'
        ]
    
        selectors.forEach((selector) => {
            const elements = document.querySelectorAll(selector);
            elements.forEach((element) => {
                element.innerHTML = translator.translate(element.innerHTML);
            });
        });
    
        toastSelector.forEach((toast) => {
            const elements = document.querySelectorAll(toast);
            elements.forEach((element) => {
                element.innerHTML = translator.translate(element.innerHTML);
            });
        });

    } catch (error) {
        console.log(error);
    }
}


// Test
async function tester() {
    return new Promise((resolve, reject) => {
        consolelog("run a promise");
    });
}