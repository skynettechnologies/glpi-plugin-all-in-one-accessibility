const script = document.createElement('script');
script.src = 'https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode=#420083&token=ADAAIOA-FDFA7781E59B83725BDF12926F04414D&position=bottom_right'; // URL or relative path
script.type = 'text/javascript';
script.onload = () => {
    console.log('Script loaded!');
};
document.head.appendChild(script); // or document.body
