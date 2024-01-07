/*Processed by Thols Labs on 7/1/2024 @ 13:59:28 https://www.github.com/tholkappiar */
 // TODO : Remove the api and generate the normal the fingerprint.

    // Initialize the agent once at web application startup.
    // Alternatively initialize as early on the page as possible.
    const fpPromise = import('https://openfpcdn.io/fingerprintjs/v3')
        .then(FingerprintJS => FingerprintJS.load())

    // Analyze the visitor when necessary.
    fpPromise
        .then(fp => fp.get())
        .then(result => {
            const visitorId = result.visitorId;
            // console.log(visitorId);
            document.getElementById('fingerprint').value = visitorId;
        })

    // console.log(result.requestId, "visitor : " + result.visitorId))

    // this is just test file
    var a = 5;
    console.log(a);
//# sourceMappingURL=app.js.map