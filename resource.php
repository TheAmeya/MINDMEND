<?php
session_start();
require 'db1.php';  // Assuming you have a database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login1.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Library</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #4CAF50;
            padding: 15px;
            text-align: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 18px;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .article {
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .article h2 {
            color: #333;
        }
        .article p {
            line-height: 1.6;
            color: #555;
        }
        .loader {
            text-align: center;
            display: none;
            color: #4CAF50;
        }
        .search-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }
        .search-bar {
            width: 100%;
            max-width: 500px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        /* Style for the call sign button */
.call-sign {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #ff5c5c;
    color: white;
    padding: 10px 15px;
    border-radius: 20px;
    font-size: 14px;
    text-align: center;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

/* Style for the pop-up */
.popup {
    display: none;
    position: fixed;
    bottom: 70px;
    right: 20px;
    background-color: #ffffff;
    color: #333333;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    font-size: 16px;
    width: 250px;
    text-align: center;
    z-index: 1001;
}

/* Close button */
.close-btn {
    cursor: pointer;
    color: #ff5c5c;
    font-weight: bold;
    float: right;
    margin-left: 10px;
}

    </style>
</head>
<body>
<?php include('navbar.php'); ?>

<div class="container" id="article-container">
    <div class="article">
        <h2>Managing Stress: Practical Tips for a Calmer Mind</h2>
        <p>Stress is something we all experience from time to time. It’s a natural response to challenges or perceived threats. However, too much stress can take a toll on our mental and physical health. Learning how to manage stress effectively is essential for maintaining a balanced and fulfilling life. Here are some simple but effective strategies you can incorporate into your daily routine to help reduce stress and find calm.</p>
        <h3>1. Practice Mindful Breathing</h3>
        <p>Mindful breathing is a quick and simple way to relax. Whenever you feel stressed, take a few moments to focus on your breathing: Inhale slowly through your nose, letting your belly expand. Hold for a second, and then exhale slowly through your mouth. Repeat for a few cycles, paying attention to the sensation of the breath. This technique helps activate the body’s relaxation response, reducing stress almost immediately.</p>
        <h3>2. Take Breaks and Prioritize Self-Care</h3>
        <p>Setting aside time for self-care is crucial for managing stress. Short breaks during work, a walk outside, or a relaxing bath can help recharge your mind and body. Remember that self-care isn’t a luxury; it’s a necessity for overall well-being.</p>
        <h3>3. Stay Physically Active</h3>
        <p>Exercise is a proven stress reliever. Physical activity releases endorphins, the body’s natural mood boosters, and helps improve sleep. Aim for at least 30 minutes of moderate activity, like walking or yoga, a few times a week. It doesn’t have to be strenuous to be effective!</p>
    </div>
</div>
<!-- Call sign button -->
<div class="call-sign" onclick="togglePopup()">Need Help?</div>

<!-- Pop-up with suicide prevention number -->
<div class="popup" id="popup">
    <span class="close-btn" onclick="togglePopup()">x</span>
    Suicide Prevention Hotline: <br><strong>1-800-273-8255</strong>
</div>


<div class="loader" id="loader">Loading more articles...</div>

<script>
    let loading = false;

function loadMoreArticles() {
    if (loading) return;

    loading = true;
    document.getElementById('loader').style.display = 'block';

    setTimeout(() => {
        const articleContainer = document.getElementById('article-container');

        const articles = [
    
    
    {
        title: "Overcoming Social Anxiety",
        content: "Social anxiety can be overwhelming and makes even routine interactions feel challenging. It often involves intense fear of judgment, embarrassment, or rejection, causing people to avoid social situations. Coping with social anxiety starts with understanding it’s manageable. Cognitive Behavioral Therapy (CBT) is effective, helping people reframe their thoughts and gradually face social situations in a safe, controlled way. Techniques like exposure therapy, where you slowly introduce feared situations, can also help. For example, start by practicing social skills with friends, then move to speaking to strangers. Self-care practices, like mindfulness, can also reduce anxiety by keeping you present instead of focusing on potential negative outcomes. Avoiding caffeine and adopting regular physical activity are additional ways to reduce anxiety, as they improve overall mental wellness. If you experience severe symptoms, seeking guidance from a mental health professional is advisable. Support groups are also a valuable resource, as they provide a sense of community and understanding. Building confidence and reducing social anxiety takes time and patience, but small, gradual steps can lead to substantial progress and, ultimately, a more comfortable experience in social settings."
    },
    {
        title: "Improving Sleep for Better Mental Health",
        content: "Sleep is critical for mental health. Quality sleep allows the brain to process emotions, reduce stress, and maintain cognitive functions. Lack of sleep can contribute to irritability, anxiety, and even long-term mental health issues like depression. Improving sleep starts with establishing a routine: aim to go to bed and wake up at the same time each day, even on weekends. Create a relaxing pre-sleep ritual, like reading, stretching, or deep breathing, which signals to the body that it's time to unwind. Avoid screens an hour before bed, as blue light interferes with melatonin production, making it harder to fall asleep. Reducing caffeine intake, especially in the afternoon, can prevent restlessness at night. Ensuring your sleep environment is dark, quiet, and comfortable also promotes better rest. If intrusive thoughts keep you awake, try journaling before bed to release worries onto paper. In cases where sleep problems persist, it may help to speak with a professional, as underlying conditions like insomnia or sleep apnea could be factors. Prioritizing sleep contributes significantly to mental clarity, emotional resilience, and overall well-being, making it a cornerstone of mental health care."
    },
    {
        title: "Building Resilience in Challenging Times",
        content: "Resilience is the ability to adapt and bounce back from adversity, which is essential for mental health. Life challenges, such as job stress, loss, or major changes, can feel overwhelming without resilience. Building resilience starts with developing a growth mindset, where setbacks are seen as opportunities to learn and grow. Practicing gratitude is another helpful tool; focusing on positive aspects of life helps balance negativity. Physical self-care, like regular exercise and a balanced diet, also contributes to resilience by keeping the body and mind strong. Strong social connections provide emotional support, so maintaining relationships with family, friends, or support groups can foster resilience. Additionally, cultivating mindfulness through meditation or simple breathing exercises keeps you grounded, helping to reduce stress and improve focus. When faced with challenges, break down problems into manageable steps, focusing on what you can control. Remember, resilience doesn’t mean you won’t feel stress or anxiety; rather, it helps you cope effectively. Over time, these practices can build mental strength and confidence, helping you handle life’s challenges with grace and optimism."
    },
    {
        title: "Understanding ADHD in Adults",
        content: "Attention Deficit Hyperactivity Disorder (ADHD) isn’t exclusive to children; many adults struggle with it, often without realizing. Adult ADHD can manifest as impulsivity, forgetfulness, and difficulty organizing tasks, impacting personal and professional life. Recognizing the signs is the first step to managing ADHD effectively. Creating structure and routine helps maintain focus, as does breaking tasks into smaller, manageable chunks. Minimizing distractions, like turning off notifications, can also improve productivity. Exercise, particularly aerobic activities, has been shown to improve cognitive function and reduce symptoms. Mindfulness practices, such as meditation, can help regulate emotions and reduce impulsivity. If you suspect you have ADHD, consult a healthcare professional for a proper diagnosis and guidance on developing a personalized treatment plan. With the right strategies and support, adults with ADHD can thrive and reach their full potential."
    },
    {
        title: "Overcoming Social Anxiety",
        content: "Social anxiety can be overwhelming and makes even routine interactions feel challenging. It often involves intense fear of judgment, embarrassment, or rejection, causing people to avoid social situations. Coping with social anxiety starts with understanding it’s manageable. Cognitive Behavioral Therapy (CBT) is effective, helping people reframe their thoughts and gradually face social situations in a safe, controlled way. Techniques like exposure therapy, where you slowly introduce feared situations, can also help. For example, start by practicing social skills with friends, then move to speaking to strangers. Self-care practices, like mindfulness, can also reduce anxiety by keeping you present instead of focusing on potential negative outcomes. Avoiding caffeine and adopting regular physical activity are additional ways to reduce anxiety, as they improve overall mental wellness. If you experience severe symptoms, seeking guidance from a mental health professional is advisable. Support groups are also a valuable resource, as they provide a sense of community and understanding. Building confidence and reducing social anxiety takes time and patience, but small, gradual steps can lead to substantial progress and, ultimately, a more comfortable experience in social settings."
    },
    {
        title: "Improving Sleep for Better Mental Health",
        content: "Sleep is critical for mental health. Quality sleep allows the brain to process emotions, reduce stress, and maintain cognitive functions. Lack of sleep can contribute to irritability, anxiety, and even long-term mental health issues like depression. Improving sleep starts with establishing a routine: aim to go to bed and wake up at the same time each day, even on weekends. Create a relaxing pre-sleep ritual, like reading, stretching, or deep breathing, which signals to the body that it's time to unwind. Avoid screens an hour before bed, as blue light interferes with melatonin production, making it harder to fall asleep. Reducing caffeine intake, especially in the afternoon, can prevent restlessness at night. Ensuring your sleep environment is dark, quiet, and comfortable also promotes better rest. If intrusive thoughts keep you awake, try journaling before bed to release worries onto paper. In cases where sleep problems persist, it may help to speak with a professional, as underlying conditions like insomnia or sleep apnea could be factors. Prioritizing sleep contributes significantly to mental clarity, emotional resilience, and overall well-being, making it a cornerstone of mental health care."
    },
    {
        title: "Building Resilience in Challenging Times",
        content: "Resilience is the ability to adapt and bounce back from adversity, which is essential for mental health. Life challenges, such as job stress, loss, or major changes, can feel overwhelming without resilience. Building resilience starts with developing a growth mindset, where setbacks are seen as opportunities to learn and grow. Practicing gratitude is another helpful tool; focusing on positive aspects of life helps balance negativity. Physical self-care, like regular exercise and a balanced diet, also contributes to resilience by keeping the body and mind strong. Strong social connections provide emotional support, so maintaining relationships with family, friends, or support groups can foster resilience. Additionally, cultivating mindfulness through meditation or simple breathing exercises keeps you grounded, helping to reduce stress and improve focus. When faced with challenges, break down problems into manageable steps, focusing on what you can control. Remember, resilience doesn’t mean you won’t feel stress or anxiety; rather, it helps you cope effectively. Over time, these practices can build mental strength and confidence, helping you handle life’s challenges with grace and optimism."
    },
    {
        title: "Understanding ADHD in Adults",
        content: "Attention Deficit Hyperactivity Disorder (ADHD) isn’t exclusive to children; many adults struggle with it, often without realizing. Adult ADHD can manifest as impulsivity, forgetfulness, and difficulty organizing tasks, impacting personal and professional life. Recognizing the signs is the first step to managing ADHD effectively. Creating structure can be incredibly beneficial: use planners, set reminders, and break tasks into smaller, achievable goals. Exercise is a natural outlet for excess energy and also boosts mood by releasing endorphins, which can improve focus. Mindfulness techniques, like meditation, can help reduce impulsivity by encouraging present-moment awareness. Therapy, particularly Cognitive Behavioral Therapy (CBT), is effective for ADHD, as it helps individuals develop coping strategies and address negative thought patterns. Medication, under a professional’s guidance, may also be an option to help regulate focus. Support groups are another resource, providing understanding and strategies from others with similar experiences. Building a lifestyle that prioritizes organization, healthy habits, and self-compassion can significantly improve the quality of life for adults with ADHD."
    },
    {
        title: "Managing Anger Constructively",
        content: "Anger is a natural response to frustration or perceived injustice, but managing it constructively is key to healthy relationships and personal well-being. Understanding your triggers—situations or people that tend to spark anger—is an important first step. Once you know your triggers, practice taking a pause: count to ten, or take a few deep breaths before responding. This brief moment can provide perspective and prevent impulsive reactions. Physical activity is a helpful outlet for anger, as exercise releases tension and reduces stress hormones. Journaling your feelings can also clarify the root causes of your anger, helping you see patterns and potential solutions. Practicing assertive communication, where you express your feelings calmly and respectfully, is essential in managing anger constructively. Techniques like 'I feel' statements allow you to communicate without blame, which can help resolve conflicts more peacefully. Over time, these practices lead to better emotional control and improved relationships. In cases where anger feels overwhelming or uncontrollable, anger management classes or counseling can provide additional strategies for maintaining emotional balance."
    },
    {
        title: "Coping with Depression",
        content: "Depression is a pervasive mental health condition that can affect every aspect of life, making daily tasks feel insurmountable. It often manifests as persistent sadness, fatigue, or a disinterest in activities that once brought joy. Recognizing the symptoms is the first step toward managing depression effectively. Establishing a daily routine can provide structure, helping to create a sense of normalcy. Regular physical activity is essential; even a daily walk can release endorphins, boosting mood and energy levels. Social connections are vital; reaching out to friends or family can alleviate feelings of isolation and provide emotional support. Practicing self-compassion is crucial—be gentle with yourself and avoid negative self-talk. Mindfulness practices, such as meditation and deep breathing exercises, can ground your thoughts and help manage overwhelming feelings. Engaging in creative outlets, such as art or writing, provides an essential means of expression. If symptoms persist or become severe, seeking professional help through therapy or counseling is advisable, as mental health professionals can offer tailored coping strategies. Remember, recovery from depression is a journey, and it’s okay to seek help along the way."
    },
    {
        title: "The Importance of Mindfulness in Daily Life",
        content: "Mindfulness is the practice of paying attention to the present moment without judgment, and it can significantly enhance mental well-being. Engaging in mindfulness can help reduce stress and anxiety, improve emotional regulation, and even alleviate physical pain. Start by incorporating simple mindfulness techniques into your daily routine, such as focusing on your breath for a few minutes or observing your surroundings without distractions. Mindful eating is another effective practice; savor each bite of your food to foster a deeper connection with your body. Dedicating time for mindfulness meditation, even just 5-10 minutes daily, can help clear your mind and enhance focus. Keeping a mindfulness journal can also be beneficial, allowing you to track your thoughts and feelings, fostering greater self-awareness. Mindfulness encourages you to respond to situations thoughtfully rather than react impulsively, leading to healthier interpersonal relationships. Additionally, practicing mindfulness can help cultivate gratitude, allowing you to appreciate the present rather than dwell on past regrets or future anxieties. With consistent practice, mindfulness can lead to improved emotional resilience and a greater overall sense of fulfillment in life."
    },
    {
        title: "Navigating Grief and Loss",
        content: "Grief is a natural response to loss, yet it can feel isolating and overwhelming. The grieving process is highly individual; everyone experiences it differently, and there is no right or wrong way to navigate it. Allowing yourself to fully feel your emotions—whether sadness, anger, or confusion—is essential for healing. Engaging in rituals, such as memorial services or personal remembrances, can provide closure and honor the lost loved one. It’s crucial to reach out for support during this time; talking to friends, family, or joining a support group can create a sense of community and understanding. Journaling your thoughts and feelings can also be therapeutic, offering an outlet for your emotions. Practicing self-care—maintaining a healthy diet, exercising, and ensuring adequate sleep—is vital as well. It’s also important to remember that grief doesn’t have a set timeline; it can come in waves, often resurfacing unexpectedly. If grief becomes debilitating or persistent, seeking help from a mental health professional can provide additional coping strategies and support. Healing takes time, but it is possible to find joy and meaning in life again after loss."
    },
    {
        title: "Strategies for Combating Procrastination",
        content: "Procrastination can significantly hinder productivity, leading to feelings of guilt, anxiety, and stress. Understanding the underlying causes of procrastination—such as fear of failure, perfectionism, or feeling overwhelmed—is the first step to overcoming it. One effective strategy is to break tasks into smaller, manageable steps. This makes the work seem less daunting and easier to tackle. Utilize tools like to-do lists or digital planners to organize your tasks and visualize your progress. Setting specific deadlines for each task can create accountability and motivate you to take action. Another helpful technique is the Pomodoro Technique, where you work for 25 minutes followed by a 5-minute break. This can enhance focus without causing burnout. Creating a distraction-free environment is essential; minimize interruptions by silencing notifications and creating a designated workspace. Practicing self-compassion is equally important; recognize that everyone procrastinates at times. Finally, reward yourself for completing tasks to create positive reinforcement, encouraging a proactive mindset. By implementing these strategies, you can improve your productivity and reduce the stress associated with procrastination."
    },
    {
        title: "Cultivating a Positive Body Image",
        content: "A positive body image is crucial for overall mental health and self-esteem. Many factors influence body image, including media portrayals, societal pressures, and personal experiences. To cultivate a positive body image, it’s essential to practice self-acceptance. Focus on the strengths and capabilities of your body rather than perceived flaws. Engaging in positive self-talk is vital; challenge negative thoughts and replace them with affirmations about your worth. Surrounding yourself with supportive people who celebrate diversity in body shapes and sizes can further foster a healthy self-image. Consider limiting exposure to social media accounts that promote unrealistic beauty standards, as they can contribute to negative feelings about your body. Engage in activities that make you feel good in your body, such as dancing, yoga, or sports. These activities not only promote physical health but also boost mental well-being. Finally, remember that your worth is not determined by your appearance; cultivating self-love and acceptance can lead to a healthier, more positive relationship with your body, ultimately enhancing your quality of life."
    },
    {
        title: "Understanding and Managing Anxiety",
        content: "Anxiety is a common mental health issue characterized by excessive worry, fear, or nervousness about everyday situations. While everyone experiences anxiety to some degree, chronic anxiety can disrupt daily life and affect overall well-being. Recognizing the signs—such as restlessness, rapid heartbeat, or difficulty concentrating—is essential for effective management. Practicing relaxation techniques, such as deep breathing, progressive muscle relaxation, or mindfulness meditation, can help reduce immediate feelings of anxiety. Establishing a daily routine can also provide a sense of control and stability. Regular physical activity is beneficial; exercise releases endorphins that enhance mood and alleviate stress. Journaling your thoughts and feelings can clarify anxieties and help identify triggers. It’s crucial to challenge negative thought patterns by reframing them into more realistic perspectives. Connecting with supportive friends or family can provide reassurance and understanding. If anxiety becomes overwhelming, seeking help from a mental health professional is advisable, as they can offer tailored strategies and possibly recommend therapy or medication. Remember, managing anxiety is a process, and taking small, proactive steps can lead to significant improvements over time."
    },
    {
        title: "The Role of Nutrition in Mental Health",
        content: "Nutrition plays a vital role in mental health, impacting mood, energy levels, and overall well-being. A balanced diet rich in nutrients can support cognitive function and emotional stability. Consuming whole foods, such as fruits, vegetables, whole grains, and lean proteins, provides essential vitamins and minerals that nourish the brain. Omega-3 fatty acids, found in fish, flaxseeds, and walnuts, are particularly beneficial for brain health and may help reduce symptoms of depression and anxiety. Additionally, incorporating probiotics from yogurt or fermented foods can support gut health, which is increasingly linked to mental health. Staying hydrated is equally important, as dehydration can lead to fatigue and mood swings. Avoiding excessive sugar and processed foods can help stabilize energy levels and prevent mood crashes. Meal planning and preparing healthy snacks can prevent impulsive eating and encourage better food choices. If you're unsure where to start, consider consulting a registered dietitian or nutritionist, who can provide personalized guidance. Remember, nourishing your body with wholesome foods can significantly impact your mental health and overall quality of life."
    },
    {
        title: "The Power of Gratitude in Mental Health",
        content: "Practicing gratitude is a powerful tool for enhancing mental health and overall well-being. Regularly acknowledging and appreciating the positive aspects of life can shift focus away from negative thoughts and foster a sense of contentment. Keeping a gratitude journal is a simple yet effective practice; each day, write down three things you are grateful for, no matter how small. This encourages a positive mindset and helps build resilience against stress. Sharing gratitude with others, whether through verbal expressions or written notes, can strengthen relationships and foster a supportive community. Engaging in acts of kindness—volunteering, helping a neighbor, or simply offering a compliment—can also enhance feelings of gratitude and fulfillment. Furthermore, practicing mindfulness can help deepen your appreciation for the present moment, allowing you to recognize and savor life's simple pleasures. Research has shown that cultivating gratitude can lead to improved emotional health, increased happiness, and even better physical health. By incorporating gratitude practices into your daily routine, you can enhance your perspective, reduce negative emotions, and foster a more positive outlook on life."
    },
    {
        title: "Setting Healthy Boundaries for Mental Well-being",
        content: "Establishing healthy boundaries is essential for maintaining mental well-being and fostering healthy relationships. Boundaries define how you want to be treated by others, ensuring that your needs are respected. Start by identifying areas in your life where you feel overwhelmed or taken advantage of. Communicate your limits clearly and assertively, whether it’s regarding work, family obligations, or social interactions. It's important to remember that saying 'no' is a valid response and can protect your mental health. Practice self-awareness to understand your emotional triggers and recognize when your boundaries are being crossed. Additionally, respect the boundaries of others to foster mutual understanding and respect in relationships. Prioritizing self-care is crucial; allocate time for activities that recharge your energy and nurture your well-being. If you struggle to establish boundaries, consider seeking guidance from a mental health professional, who can provide strategies and support. Remember, setting boundaries is not selfish; it’s a necessary aspect of self-care that enables you to maintain balance and cultivate healthier relationships."
    },
    {
        title: "The Benefits of Art Therapy for Mental Health",
        content: "Art therapy is a creative approach to mental health treatment that uses artistic expression as a therapeutic tool. It can be particularly beneficial for individuals who find it challenging to articulate their feelings verbally. Through various forms of art—such as painting, drawing, or sculpture—participants can explore their emotions, reduce anxiety, and gain insights into their inner experiences. Art therapy encourages self-expression and can facilitate healing by allowing individuals to visualize their thoughts and feelings. It can be particularly effective for those dealing with trauma, grief, or mental health conditions like depression and anxiety. Engaging in creative activities stimulates the brain's reward system, promoting feelings of accomplishment and joy. Additionally, art therapy can enhance mindfulness, as it requires focused attention on the creative process. Whether in a one-on-one setting or a group, art therapy provides a safe space to explore and process emotions without judgment. If you're interested in art therapy, consider finding a licensed art therapist who can guide you through the process. Remember, the goal of art therapy is not to create a masterpiece but to use creativity as a means of personal exploration and healing."
    },
    {
        title: "The Impact of Stress on Mental Health",
        content: "Stress is a natural response to life's challenges, but chronic stress can significantly impact mental health. When stress becomes persistent, it can lead to anxiety, depression, and various physical health issues. Understanding your stressors is crucial; these can include work pressures, relationship problems, or financial concerns. One effective way to manage stress is to identify and implement coping strategies. Mindfulness techniques, such as meditation and deep breathing exercises, can help reduce immediate stress and promote relaxation. Regular physical activity is also essential; exercise releases endorphins, which can improve mood and decrease stress levels. Developing a strong social support system is beneficial; talking to friends or family can provide comfort and perspective. Time management skills can help you prioritize tasks and reduce feelings of being overwhelmed. Additionally, engaging in hobbies or activities you enjoy can serve as a positive distraction from stress. If stress becomes unmanageable, seeking help from a mental health professional is advisable. They can provide personalized strategies and support. Remember, managing stress is essential for maintaining overall mental well-being, and taking proactive steps can lead to a healthier, more balanced life."
    },
    {
        title: "Understanding the Spectrum of Autism",
        content: "Autism Spectrum Disorder (ASD) is a complex neurodevelopmental condition characterized by challenges in social interaction, communication, and behavior. Individuals with ASD may exhibit a range of symptoms, from mild to severe, which can affect their daily lives. Understanding that autism exists on a spectrum is crucial; no two individuals with autism are the same. Early diagnosis and intervention can significantly improve outcomes, enabling individuals to develop essential skills and thrive in various settings. Strategies such as Applied Behavior Analysis (ABA) and speech therapy can provide tailored support. Creating an inclusive environment—whether at school, work, or home—is vital for promoting acceptance and understanding. Educating peers about autism can foster empathy and reduce stigma. Support groups and community resources can offer valuable connections for individuals with autism and their families. Additionally, focusing on the strengths of individuals with ASD, such as attention to detail or unique problem-solving skills, can help them find fulfilling careers and hobbies. Remember, promoting awareness and understanding of autism benefits not only individuals on the spectrum but also society as a whole."
    },
    {
        title: "The Benefits of Journaling for Mental Health",
        content: "Journaling is a powerful tool for enhancing mental health and emotional well-being. Writing about thoughts and feelings can provide clarity, helping individuals process complex emotions and experiences. It allows for self-reflection, enabling a deeper understanding of personal patterns, triggers, and responses. Regular journaling can reduce anxiety by providing an outlet for expressing fears and concerns. It can also boost mood by facilitating gratitude practices; writing down positive experiences or things you are thankful for can shift focus away from negativity. Journaling can be particularly beneficial during difficult times, serving as a safe space to explore feelings of grief, stress, or frustration. Different journaling methods, such as bullet journaling or art journaling, can cater to individual preferences and creativity. Additionally, setting aside time for daily or weekly journaling can create a valuable routine that encourages self-care. If you’re unsure where to start, consider using prompts that inspire reflection or gratitude. Remember, journaling is a personal process; there’s no right or wrong way to do it. The key is to be honest and open with yourself, allowing for growth and healing through the written word."
    },
    {
        title: "Understanding the Role of Sleep in Mental Health",
        content: "Sleep plays a crucial role in maintaining mental health, yet many individuals overlook its importance. Quality sleep is essential for cognitive functions, emotional regulation, and overall well-being. Lack of sleep can lead to irritability, difficulty concentrating, and increased susceptibility to stress and anxiety. Establishing a consistent sleep schedule is vital; going to bed and waking up at the same time each day helps regulate the body’s internal clock. Creating a relaxing bedtime routine—such as reading, taking a warm bath, or practicing deep breathing—signals the body that it's time to unwind. Limiting exposure to screens before bed is essential, as blue light can interfere with melatonin production, making it harder to fall asleep. Creating a sleep-friendly environment—dark, cool, and quiet—can enhance sleep quality. Additionally, avoiding caffeine and heavy meals in the evening can prevent disruptions to sleep. If sleep problems persist, it may be beneficial to consult a healthcare professional, as underlying conditions like insomnia or sleep apnea could be affecting rest. Prioritizing sleep can lead to improved mental clarity, emotional resilience, and overall health, making it a cornerstone of self-care."
    },
    {
        title: "The Importance of Self-Compassion in Mental Health",
        content: "Self-compassion is the practice of treating oneself with kindness and understanding, especially during times of struggle. It involves recognizing that everyone makes mistakes and experiences difficulties, which fosters a sense of connection and shared humanity. Practicing self-compassion can reduce feelings of inadequacy, anxiety, and depression. One way to cultivate self-compassion is to replace critical self-talk with supportive and encouraging language. When faced with setbacks, instead of harshly judging yourself, consider how you would respond to a friend in a similar situation. Engaging in mindfulness can also enhance self-compassion, allowing you to acknowledge your feelings without judgment. Setting aside time for self-care activities that bring joy and relaxation is essential for nurturing compassion toward oneself. Journaling about experiences and feelings can also help process emotions and reinforce self-kindness. If you find it challenging to practice self-compassion, consider seeking guidance from a therapist, who can provide tools and strategies for development. Remember, self-compassion is not self-indulgence; it’s a vital aspect of mental health that promotes resilience and emotional well-being."
    }
    
    
];

        articles.forEach(article => {
            const newArticle = document.createElement('div');
            newArticle.classList.add('article');
            newArticle.innerHTML = `
                <h2>${article.title}</h2>
                <p>${article.content}</p>
            `;
            articleContainer.appendChild(newArticle);
        });

        document.getElementById('loader').style.display = 'none';
        loading = false;
    }, 1000);
}

window.addEventListener('scroll', () => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
        loadMoreArticles();
    }
});

function displayArticles(filteredArticles) {
        const container = document.getElementById('article-container');
        container.innerHTML = ''; // Clear existing articles
        filteredArticles.forEach(article => {
            const articleDiv = document.createElement('div');
            articleDiv.className = 'article';
            articleDiv.innerHTML = `<h2>${article.title}</h2><p>${article.content}</p>`;
            container.appendChild(articleDiv);
        });
    }

    function filterArticles() {
        const searchBar = document.getElementById('search-bar');
        const query = searchBar.value.toLowerCase();
        const filteredArticles = articles.filter(article => {
            return article.title.toLowerCase().includes(query) || article.content.toLowerCase().includes(query);
        });
        displayArticles(filteredArticles);
    }

    // Initial display of all articles
    displayArticles(articles);
    // Function to toggle the pop-up visibility
function togglePopup() {
    var popup = document.getElementById("popup");
    popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
}

</script>

</body>
</html>
