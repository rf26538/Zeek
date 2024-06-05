$(function() {

    $('#downloadFile').click(function(e) {
        e.preventDefault();
        var filename = $('#fileName').attr('src').split('/').pop();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        let assignmentId = $('#asId').val();
        
        $.ajax({
            url: pageData.routes.download_assignment,
            type: 'post',
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: { aId: assignmentId },
            success: function(data) {
                fetch(data.filePath)
                .then(response => response.blob())
                .then(blob => {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = data.filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                })
                .catch(error => console.error('Error downloading file:', error));
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    $('#payButton').click(function(event) {
        event.preventDefault();
        var amount = $('#amount').val();
        var amount = $('#amount').val();
    
        var options = {
            key: 'YOUR_RAZERPAY_KEY', 
            amount: amount * 100,
            currency: 'INR',
            name: 'Your Company Name',
            description: 'Payment for Service',
            handler: function (response) {
                console.log(response);
                alert('Payment successful');
            },
            prefill: {
                name: 'Your Name',
                email: 'your_email@example.com',
                contact: '1234567890'
            },
            notes: {
                address: 'Your Address'
            },
            theme: {
                color: '#3399cc'
            }
        };
        var rzp = new Razorpay(options);
        rzp.open();
    });
});