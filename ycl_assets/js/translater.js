/**
 * need to update depends on user type at header **
 */
const baseUrl = project_url + "/";

// Global_Constants
const languageData = fetchAllText();
const userLanguage = initializeLanguage();

async function updateUserLanguage(language) {
    try {
        const response = await $.ajax({
            url: baseUrl + "translator/updateUserLanguage",
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

async function updatePageLanguage(language) {
    try {
        const arrEnglishToSpanishData = await fetchAllText();
        (async () => {
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

function initializeLanguage() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: baseUrl + "translator/initializeUserLanguageSetting",
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

function initializeLanguageSettings() {
    disableUserInput();

    $.ajax({
        url: baseUrl + "translator/initializeUserLanguageSetting",
        dataType: 'JSON',
        method: 'POST',
        success: async function(response) {
            try {
                if (response) {
                    const language = response[0].language;
                    if (language) {
                        console.log("Initializing : " + language);
                        if ($('#languageSelect')) {
                            $('#languageSelect').val(language);
                        }

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

function fetchAllText() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: baseUrl + "translator/getTextData",
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

function translateText(selectedLanguage, arrData) {
    return new Promise((resolve, reject) => {
        let finishText = new Array();
        
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

// Single translation
function getTranslatedSelectAccess(textData) {
    return new Promise((resolve, reject) => {
        // const selectedLanguage = "spanish";
        const selectedLanguage = $('#languageSelect').val();
        const translationData = fetchAllText();
        
        translationData.then((arrData) => {
            for (let i = 0; i < arrData.length; i++) {
                if (arrData[i].english_text === textData) {
                    textData = arrData[i][selectedLanguage + '_text'];
                }
            }
            resolve(textData); // Resolve the promise with the final value of selectAccess
        }).catch(reject); // Reject the promise if there's an error fetching translationData
    });
}



// Utilities
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