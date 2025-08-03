document.getElementById("logoutBtn").addEventListener('click', function () {

    fetch("../../../backend/api/logout.php", {
        method: "POST",
        credentials: "include",
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = '../comsa/COMSA-NOW/index.html';
            } else {
                alert('Logout failed. Please try again.');
            }
        })
        .catch(err => {
            console.error('Logout error:', err);
            alert('Something went wrong during logout.');
        })

})