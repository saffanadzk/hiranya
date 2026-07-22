/**
 * Hiranya Dynamic QR Code Helper
 * Automatically loads qrcode.js from CDN and generates a QR code into the target element container.
 */
function generateQRCode(elementId, text, width = 150, height = 150) {
    const container = document.getElementById(elementId);
    if (!container) {
        console.warn(`QR Code container #${elementId} not found.`);
        return;
    }
    
    // Clear container
    container.innerHTML = '';

    const executeQR = () => {
        try {
            new QRCode(container, {
                text: text,
                width: width,
                height: height,
                colorDark: "#1C2431",
                colorLight: "#fcfaf7",
                correctLevel: QRCode.CorrectLevel.M
            });
        } catch (e) {
            console.error("Failed to generate QR Code: ", e);
        }
    };

    if (typeof QRCode === 'undefined') {
        const script = document.createElement('script');
        script.src = "https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js";
        script.integrity = "sha512-CNgIRecGo7nOMOuTB0l8xxEGIVKB126YiOtMTPDvpXZT98WhUxIVtLDQsBfRJdfe2dfUxECnyGN621deUs1YON==";
        script.crossOrigin = "anonymous";
        script.referrerPolicy = "no-referrer";
        script.onload = executeQR;
        document.head.appendChild(script);
    } else {
        executeQR();
    }
}
