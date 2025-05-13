<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Library</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; }
        .resource-library { max-width: 800px; margin: auto; padding: 20px; }
        .resource-item { background-color: white; padding: 20px; border-radius: 5px; margin-bottom: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        .resource-title { font-size: 24px; margin: 0 0 10px; }
        .resource-content { font-size: 16px; color: #555; }
        #loader { text-align: center; padding: 20px; display: none; }
    </style>
</head>
<body>

<div class="resource-library">
    <h1>Resource Library</h1>
    <div id="resource-container">
        <!-- Articles will be displayed here -->
    </div>
    <div id="loader">Loading...</div>
</div>

<script>
// Preloaded articles as an array of objects
const articles = [
    { title: "Understanding Anxiety", content: "Anxiety is a feeling of worry, nervousness, or unease." },
    { title: "Tips for Managing Stress", content: "Stress management is essential for a balanced life." },
    { title: "The Benefits of Meditation", content: "Meditation is a practice where an individual uses a technique." },
    { title: "Building Resilience", content: "Resilience is the process of adapting well in the face of adversity." },
    { title: "Mental Health Myths", content: "Common misconceptions around mental health." },
    { title: "Self-Care Techniques", content: "Self-care is an essential part of maintaining mental health." },
    { title: "The Power of Positive Thinking", content: "Positive thinking can transform your outlook on life." },
    { title: "Understanding Depression", content: "Depression is more than just feeling sad." },
    { title: "Setting Healthy Boundaries", content: "Boundaries are essential for healthy relationships." },
    { title: "Mindfulness Practices", content: "Mindfulness is the basic human ability to be fully present." },
    // Add as many articles as you need
];

const limit = 3;  // Number of articles to load at once
let offset = 0;   // Initial index to start loading from

function loadArticles() {
    const resourceContainer = document.getElementById('resource-container');
    const end = Math.min(offset + limit, articles.length);

    // Load the next set of articles
    for (let i = offset; i < end; i++) {
        const article = articles[i];
        const articleElement = document.createElement('div');
        articleElement.className = 'resource-item';
        articleElement.innerHTML = `
            <h2 class="resource-title">${article.title}</h2>
            <p class="resource-content">${article.content}</p>
        `;
        resourceContainer.appendChild(articleElement);
    }

    offset = end;

    // Hide loader if all articles are loaded
    if (offset >= articles.length) {
        document.getElementById('loader').style.display = 'none';
    } else {
        document.getElementById('loader').style.display = 'block';
    }
}

// Infinite scroll event listener
window.addEventListener('scroll', () => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
        loadArticles();
    }
});

// Initial load
loadArticles();
</script>

</body>
</html>
