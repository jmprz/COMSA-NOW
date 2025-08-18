document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById("quickLinkForm");


    form.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("clicked")
        const formdata = new FormData(form);

        fetch("../../../backend/api/add_quick_links.php", {
            credentials: 'include',
            method: 'POST',
            body: formdata
        })
            .then(async res => {
                const text = await res.text(); // raw response
                console.log("Raw response:", text);

                try {
                    return JSON.parse(text); // attempt to parse
                } catch (err) {
                    console.error("Invalid JSON:", err);
                    throw err;
                }
            })
            .then(response => {
                if (response.success) {
                    console.log("nicee")
                    console.log(response.title)
                    console.log(response.url)
                    console.log(response.category)
                    console.log(response.icon)

                } else {
                    console.log("not nice")
                    console.log(response.title)
                    console.log(response.url)
                    console.log(response.category)
                    console.log(response.icon)
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
            });
    })






})