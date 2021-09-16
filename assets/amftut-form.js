/*
=======================================================
Elements
=======================================================
*/

const form = document.querySelector('#add-feedback');

/*
=======================================================
Actions
=======================================================
*/

form.addEventListener('submit', async e => {
    e.preventDefault();

    let data = new URLSearchParams();
    data.append('action', 'amftutPostData');

    for (let i = 0; i < form.length - 1; i++) {
        if (form[i].type === 'checkbox') {
            data.append(form[i].name, form[i].checked ? 1 : 0);
        } else {
            data.append(form[i].name, form[i].value);
        }
    }

    await fetch(object.ajaxUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Cache-Control': 'no-cache',
        },
        referrerPolicy: 'strict-origin-when-cross-origin',
        body: data
    })
        .then(alert('Thank you for your feedback. It is appreciated'))
        .then(form.reset());
});