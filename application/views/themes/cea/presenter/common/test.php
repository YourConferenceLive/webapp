<link rel="stylesheet"
    href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js">
</script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js">
</script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/jszip/jszip.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


<div class="content-wrapper p-4">
    <h1 id="text1">Edit</h1><a href="">Home</a>
    <h1 id="text2">sub title1</h1>
    <h1 id="text3">sub title2</h1>
</div>

<!-- Testing Porpuses -->
<script>
    $(document).ready(function() {
        // Timer
        const countForSeconds = (seconds) => {
            return new Promise((resolve) => {
                setTimeout(resolve, seconds * 1000);
            });
        };

        function loreTest() {
            setTimeout(() => {
                console.log("No promises made");
            }, 2000);
        }

        // Multiple data
        const loadData = async () => {
            let sec = 5;
            try {
                console.log("Counting from " + sec + " seconds...");
                await countForSeconds(sec); // Count for 5 seconds
                console.log("After " + sec + "seconds...");
                console.log("Need to count : 2 seconds...");
                console.log("Reading loreTest");
                await loreTest();
                console.log("loreTest has been read.");
                await countForSeconds(4); // Count for 5 seconds
                console.log("lorafter 4 sec.");
                await countForSeconds(4); // Count for 5 seconds
                console.log("Counting finished!");

                const data1 = {
                    userId: 1,
                    id: 1,
                    title: 'Todo 1',
                    completed: false
                };
                const data2 = {
                    userId: 2,
                    id: 2,
                    title: 'Todo 2',
                    completed: true
                };
                const data3 = {
                    userId: 3,
                    id: 3,
                    title: 'Todo 3',
                    completed: false
                };

                return [data1, data2, data3];
            } catch (err) {
                console.error("Error: " + err);
            }
        };

        // Handle data loading
        const handleData = async () => {
            try {
                const data = await loadData();
                console.log("Loaded data:", data);
                console.log("Finish counting and data loading!");
            } catch (err) {
                console.error(err);
            }
        };
        // handleData();

        // Example 2
        function findElements() {
            return new Promise((resolve, reject) => {
                const elements = document.getElementsByTagName("*");
                if (elements.length > 0) {
                    resolve(elements);
                } else {
                    reject("No elements found");
                }
            });
        }

        async function showAlert() {
            try {
                const elements = await findElements();
                const uniqueTagNames = Array.from(elements).reduce((acc, element) => {
                    const tagName = element.tagName;
                    if (!acc.includes(tagName)) {
                        acc.push(tagName);
                    }
                    return acc;
                }, []);
                console.log("Unique elements found:\n" + uniqueTagNames.join(", "));
            } catch (error) {
                console.error(error);
            }
        }

        // Method 1
        (async () => {
            // await showAlert();
        })();


        // Method 2
        async function runAwaits() {
            await handleData();
            await showAlert();
        }
        // runAwaits();

    });
</script>

<!-- Basics Promises -->
<script>
    /**
     * Jumping on the basics
     */

    // Promise

    // var globalData;

    // function fetchUserData(timer) {
    //     return new Promise((myResolve, reject) => {
    //         setTimeout(() => {
    //             const success = true;

    //             if (success) {
    //                 const userData = {
    //                     name: 'John Doe',
    //                     age: 25
    //                 };
    //                 myResolve(userData);
    //             } else {
    //                 const errorMessage = 'Failed to fetch user data';
    //                 reject(errorMessage);
    //             }
    //         }, timer);
    //     });
    // }

    // Usage of the Promise with .then() and .catch()
    // fetchUserData(3000)
    //     .then((data) => {
    //         console.log('Name:', data.name); // Handle the resolved Promise
    //         globalData = data;
    //     })
    //     .catch((error) => {
    //         console.error('Promise Error:', error); // Handle the rejected Promise
    //     });
</script>

<!-- Array of Promises -->
<script>
    /**
     * Single Promise
     * run a promise
     * retun either resolve or reject with try catch
     */
    // function fetchUserData(timer) {
    //     return new Promise((resolve, reject) => {
    //         setTimeout(() => {
    //             const success = true;

    //             if (success) {
    //                 const userData = {
    //                     name: 'John Doe',
    //                     age: 25
    //                 };
    //                 resolve(userData);
    //             } else {
    //                 const errorMessage = 'Failed to fetch user data';
    //                 reject(errorMessage);
    //             }
    //         }, timer);
    //     });
    // }

    // // Create an array of Promises
    // const promises = [
    //     fetchUserData(3000), // Promise 1
    //     fetchUserData(5000), // Promise 2
    //     fetchUserData(4000) // Promise 3
    // ];

    // // Run multiple Promises concurrently using Promise.all()
    // Promise.all(promises)
    //     .then((results) => {
    //         console.log('Results:', results); // Handle the resolved Promises
    //         results.forEach((data, index) => {
    //             console.log(`Promise ${index + 1} - Name:`, data.name);
    //         });
    //     })
    //     .catch((error) => {
    //         console.error('Promise Error:', error); // Handle any rejected Promise
    //     });
</script>

<!-- Async and Await -->
<script>
    /**
     * Async and await
     * FIFO
     * finish the first before executing the second function
     */
    // async function processPromises() {
    //     try {
    //         const promises = [
    //             fetchUserData(5000), // Promise 1
    //             fetchUserData(2000), // Promise 2
    //             fetchUserData(7000) // Promise 3
    //         ];

    //         for (let i = 0; i < promises.length; i++) {
    //             const data = await promises[i];
    //             console.log(`Promise ${i + 1} - Name:`, data.name);
    //         }
    //     } catch (error) {
    //         console.error('Promise Error:', error);
    //     }
    // }

    // processPromises();

</script>

<!-- Multiple Promises -->
<!-- Translation guide -->
<script>
    /**
     * Multiple Promise
     * simultanously
     * run multiple function at the same time
     */

    const language = "spanish";
    // Create an array of Promises
    const promises = [
        fetchImaginaryUserData(3000), // Promise 1
        fetchImaginaryUserData(2000), // Promise 2
        fetchImaginaryUserData(5000), // Promise 3
        fetchLanguage(2000),
    ];

    // Functions
    function fetchImaginaryUserData(timer) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                const success = true;

                if (success) {
                    const userData = {
                        name: 'Imaginary name',
                        age: 20
                    };
                    resolve(userData);
                } else {
                    const errorMessage = 'Failed to fetch user data';
                    reject(errorMessage);
                }
            }, timer);
        });
    }

    function fetchLanguage(timeout) {
        return new Promise((resolve, reject) => {
            baseUrl = "<?=$this->project_url?>/presenter/translator/initializeUserLanguageSetting";
            $.ajax({
                url: baseUrl,
                dataType: "JSON",
                method: "POST",
                success: function(response) {
                    setTimeout(() => {
                        if(response) {
                            const langData = {
                                language : response[0].language,
                                name: "Carlos"
                            }
                            resolve(langData);
                        }
                        else
                        {
                            const errorMessage = 'Failed to fetch language data';
                            reject(errorMessage);
                        }
                    }, timeout);
                }
            });
        });
    }

    function displayMessage() {
        console.log("Translation complete.");
    }

    function awaitPromiseList() {
        const promiseResults = promises.map((promise, index) =>
            promise
                .then((data) => {
                    if (!data.language) {
                    console.log(`Promise ${index + 1} - Name: `, data.name); // Handle the resolved Promise
                    } else {
                    console.log(`Promise ${index + 1} - Language: `, data.language);
                    }
                })
                .catch((error) => {
                    console.error(`Promise ${index + 1} Error:`, error); // Handle the rejected Promise
                })
        );

        return Promise.all(promiseResults);
    }
    
    function fetchAllText() {
        return new Promise((resolve, reject) => {
            baseUrl = "<?=$this->project_url?>/presenter/translator/getTextData";
            $.ajax({
                url: baseUrl,
                dataType: "JSON",
                method: "POST",
                success: function(response) {
                    if(response) {
                        console.log(response);
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
    // ***************************************************************************
    /**
     * Display Data
     */
    
    async function processPromises() {
        try {
            const promises = [
                fetchImaginaryUserData(2000), // Promise 1
                fetchImaginaryUserData(3000), // Promise 2
                fetchImaginaryUserData(5000), // Promise 3
                fetchLanguage(1000),
                fetchAllText()

            ];

            // Process each Promise individually as it resolves
            for (let index = 0; index < promises.length; index++) {
                const data = await promises[index];
                if (!data.language) {
                    console.log(`Promise ${index + 1} - Name: `, data.name); // Handle the resolved Promise
                } else {
                    console.log(`Promise ${index + 1} - Language: `, data.language);
                }
            }

            console.log("Done"); // Log "Done" when all promises have resolved
        } catch (error) {
            console.error("Error:", error); // Handle errors during promise processing
        }
    }
    
    // Process each Promise individually as it resolves
    // promises.forEach((promise, index) => {
    //     promise
    //         .then((data) => {
    //             if( ! data.language)
    //             {
    //                 console.log(`Promise ${index + 1} - Name: `, data.name); // Handle the resolved Promise
    //             }
    //             else
    //             {
    //                 console.log(`Promise ${index + 1} - Language: `, data.language);
    //             }
    //         })
    //         .catch((error) => {
    //             console.error(`Promise ${index + 1} Error:`, error); // Handle the rejected Promise
    //         });
    // });
    

    // processPromises();


    // awaitPromiseList()
    //     .then(() => {
    //         displayMessage()
    //     });
    // awaitPromiseList();


    // async function runAwaits() {
    //     await awaitPromiseList();
    //     await displayMessage();
    // }
    // runAwaits();

    
</script>


<!-- Switch Languange  -->
<!-- Update Version -->
<script>
    $(document).ready(function() {
        
        // Initialize the language and translate if not english
        initializeLanguageSettings();

        // Onchange event for switching language
        const languageSelect = document.getElementById("languageSelect");
        $(languageSelect).on("change", function() {
            Swal.fire({
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                    Swal.getContainer().style.pointerEvents = 'none'; // Disable user input
                }
            });

            let language = languageSelect.value;
            (async () => {
                console.log("Initializing : " + language);
                await updateUserLanguage(language);
                await updatePageLanguage(language);
                await closeSwal();
            })();

        });

    });

    // Search for elements used on the page
    function findElements() {
        const excludedElements = ['HTML', 'HEAD', 'META', 'LINK', 'TITLE', 'SCRIPT', 'STYLE', 'BODY', 'IMG'];

        return new Promise((resolve, reject) => {
            const elements = Array.from(document.getElementsByTagName("*")).filter((element) => {
                const tagName = element.tagName.toUpperCase();
                return !excludedElements.includes(tagName);
            });
            
            if (elements.length > 0) {
                resolve(elements);
            } else {
                reject("No elements found");
            }
        });
    }

    async function elementList() {
        try {
            const elements = await findElements();

            const uniqueTagNames = Array.from(elements).reduce((acc, element) => {
                const tagName = element.tagName;
                if (!acc.includes(tagName)) {
                    acc.push(tagName);
                }
                return acc;
            }, []);

            return uniqueTagNames.join(", ");
        } catch (error) {
            console.error(error);
        }
    }

    function closeSwal() {
        Swal.close();
        Swal.getContainer().style.pointerEvents = 'auto';
        console.log("Translation complete.");
    }

    function initializeLanguageSettings() {
        Swal.fire({
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
                Swal.getContainer().style.pointerEvents = 'none'; // Disable user input
            }
        });

        baseUrl = "<?=$this->project_url?>/presenter/translator/initializeUserLanguageSetting";
        $.ajax({
            url: baseUrl,
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
                console.error(xhr.responseText);
                reject(error);
            }
        });
    }

    async function updatePageLanguage(language) {
        const elementsTagName = await elementList();
        const arrEnglishToSpanishData = await fetchAllText();

        // console.log(elementsTagName);
        // Translate elements
        // V1
        // $(elementsTagName).each(function(data) {
        //     var $element = $(this);
        //     if ($element.children().length === 0) {
                
        //         // V1
        //         var originalText = $element[0].innerHTML;
        //         translateText(originalText, language, arrEnglishToSpanishData)
        //             .then((translatedText) => {
        //                 $element.text(translatedText);
        //                 // console.log(translatedText);
        //             })
        //             .catch((error) => {
        //                 console.error(error);
        //             });

               
                
        //     }
        // });

        // Translate elements
        // V2
        (async () => {
            await translateTextV2(language, arrEnglishToSpanishData);
        })();

    }


    function updateUserLanguage(language) {
        baseUrl = "<?=$this->project_url?>/presenter/translator/updateUserLanguage";

        // Start Swal loading
        Swal.showLoading();

        $.ajax({
            url: baseUrl,
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
                console.error(xhr.responseText);
            }
        });
    }

    function fetchAllText() {
        return new Promise((resolve, reject) => {
            baseUrl = "<?=$this->project_url?>/presenter/translator/getTextData";
            $.ajax({
                url: baseUrl,
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

    function translateText(originalText, selectedLanguage, arrData) {
        return new Promise(function(resolve, reject) {
            for(let i = 0; i < arrData.length; i++){
                if(originalText == arrData[i].english_text && selectedLanguage == "spanish")
                {
                    resolve(arrData[i].spanish_text);
                    return;
                }
                else if(originalText == arrData[i].spanish_text && selectedLanguage == "english")
                {
                    resolve(arrData[i].english_text);
                    return;
                }
                else if(originalText == null || originalText == "") {
                    return;
                }
            }
            reject("Translation failed.");
        });
    }

</script>

<!-- use this to translate data -->
<script>
    function replaceSpecificWords(searchWord, replacementWord) {
        const textNodes = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null, false);

        while (textNodes.nextNode()) {
            const textNode = textNodes.currentNode;
            const text = textNode.textContent;

            // Check if the search word exists in the text content
            if (text.includes(searchWord) && !isInsideScriptTag(textNode)) {
                const replacedText = text.replace(new RegExp(searchWord, 'g'), replacementWord);
                textNode.textContent = replacedText;
            }
        }
    }

    function isInsideScriptTag(node) {
        let currentNode = node.parentNode;
        while (currentNode) {
            if (currentNode.nodeName === 'SCRIPT') {
                return true;
            }
            currentNode = currentNode.parentNode;
        }
        return false;
    }

    function translateTextV2(selectedLanguage, arrData) {
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
                reject("Translation failed.");
            }
        }
    }
</script>