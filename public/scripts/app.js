(function(){

    init();


    async function init(){

        const meta$ = document.querySelector('meta[name=csrf-token]');
        const csrfTokenValue = meta$.getAttribute('content');
        const config = {
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // make sure to send this if you are using fetch
                'Content-Type': "application/json",
                'X-CSRF-Token': csrfTokenValue // use this only if you are using csrf middleware
            }
        }
        const response = await fetch('/users', config);
        const res = await response.json();
        if(!response.ok){

            console.error(res);
            return;
        }

        console.log("success", res);
    }

})();