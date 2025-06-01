fetch('assets/locales/trans.json')
    .then(response => response.json())
    .then(translations => {
        const userLanguage = navigator.language.slice(0, 2); 
        const lang = translations[userLanguage] ? userLanguage : 'en';
        document.getElementById("question").textContent = translations[lang].question;
        document.getElementById("answ-yes").textContent = translations[lang]["answ-yes"];
        document.getElementById("answ-no").textContent = translations[lang]["answ-no"];
    })
    .catch(error => console.error('Error loading translations:', error));
