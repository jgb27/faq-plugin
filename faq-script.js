document.addEventListener('DOMContentLoaded', function() {
    // Seleciona todos os elementos h3 dentro da classe .faq
    const faqs = document.querySelectorAll('.faq h3');
    faqs.forEach(faq => {
        // Adiciona um ouvinte de evento de clique para cada FAQ
        faq.addEventListener('click', function() {
            // Alterna a classe 'faq-content-show' no próximo elemento (conteúdo da FAQ)
            this.nextElementSibling.classList.toggle('faq-content-show');
        });
    });
});
