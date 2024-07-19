document.addEventListener('DOMContentLoaded', () => {
    const logo = document.querySelector('.logo');
    
    logo.addEventListener('animationiteration', () => {
        console.log('Logo morphing animation iteration');
    });
});
