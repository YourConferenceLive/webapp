class TranslationManager {
    constructor(arrData, userLanguage) {
        this.arrData = arrData;
        this.userLanguage = userLanguage;
    }

    translate(key) {
        try {
            const translation = this.arrData.find((item) => item.english_text === key);
            if (translation) {
                let language = this.userLanguage + '_text';
                // console.log(language);
                return translation[language];
            }
            return key;
        } catch (error) {
            console.log("TranslationManager: " + error);            
        }
    }

}

