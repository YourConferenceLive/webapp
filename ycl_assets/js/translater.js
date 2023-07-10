
function closeSwal() {
    const container = Swal.getContainer();
    if (container !== null) {
        container.style.pointerEvents = 'auto';
    }
    $('body').css('pointer-events', 'auto');
    Swal.close();
}

function initializeLanguageSettings2() {

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
    
    $.ajax({
        url: baseUrl + "translator/initializeUserLanguageSetting",
        dataType: 'JSON',
        method: 'POST',
        success: function(response) {
            if(response) {
                let language = response[0].language;
                if (language)
                {
                    console.log("Initializing : " + language);
                    $('#languageSelect').val(language);

                    /**
                     * Update the page language here
                     * async-await
                     * 
                     */
                    (async () => {
                        await updatePageLanguage(language);
                        await closeSwal();
                    })();
                    
                }
                else 
                {
                    console.log("Theres no language.");
                    closeSwal();
                }
            }
            else
            {
                console.log("Error response");
                closeSwal();
            }
        },
        error: function(xhr, status, error) {
            console.log("No response from server.");
            closeSwal();
        }
    });
}

function initializeLanguageSettings() {
    // Return a Promise to indicate the completion of the initialization
    return new Promise((resolve) => {
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

        $.ajax({
        url: baseUrl + "translator/initializeUserLanguageSetting",
        dataType: 'JSON',
        method: 'POST',
        success: function(response) {
            // Rest of your code for initializeLanguageSettings

            // ...

            resolve(); // Resolve the Promise to indicate completion
        },
        error: function(xhr, status, error) {
            console.log("No response from server.");
            closeSwal();

            resolve(); // Resolve the Promise even if an error occurs
        }
        });
    });
}
async function updatePageLanguage(language) {
    const arrEnglishToSpanishData = await fetchAllText();
    (async () => {
        await translateText(language, arrEnglishToSpanishData);
    })();
}

function updateUserLanguage(language) {
    // Start Swal loading
    Swal.showLoading();
    $('body').css('pointer-events', 'auto');

    // Swal.fire({
    //     allowOutsideClick: false,
    //     allowEscapeKey: false,
    //     showConfirmButton: false,
    //     willOpen: () => {
    //         Swal.showLoading();
    //         Swal.disableButtons()
    //         Swal.getContainer().style.pointerEvents = 'none'; // Disable user input
    //     }
    // });

    $.ajax({
        url: baseUrl + "translator/updateUserLanguage",
        data: {selectedLanguage : language},
        dataType: 'JSON',
        method: 'POST',
        success: function(response) {
            if(response.bool) {
                // console.log(response.msg);
            }
            else
            {
                console.log("error: " + response.msg);
            }
        },
        error: function(xhr, status, error) {
            console.log(status + ": " + error);
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
    for(let i = 0; i < arrData.length; i++){
        english_text = arrData[i].english_text;
        spanish_text = arrData[i].spanish_text;
        if(selectedLanguage == "spanish")
        {
            replaceSpecificWords(english_text, spanish_text); // searchWord, replacementWord
        }
        else if(selectedLanguage == "english")
        {
            replaceSpecificWords(spanish_text, english_text); // searchWord, replacementWord
        }
        else
        {
            console.log("Translation failed.");
        }
    }
}

function replaceSpecificWords(searchWord, replacementWord) {
    const textNodes = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null, false);

    while (textNodes.nextNode()) {
        const textNode = textNodes.currentNode;
        const text = textNode.textContent;

        // Check if the search word exists in the text content
        if (text.includes(searchWord)) {
            const escapedSearchWord = escapeRegExp(searchWord);
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