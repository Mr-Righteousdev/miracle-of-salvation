@php
$coreValues = [
    [
        'number' => '01',
        'title' => 'Jesus Christ and Salvation',
        'description' => 'Jesus Christ is central to our faith and ministry. We proclaim salvation and call people to faith, repentance and a transformed life in Christ.',
        'scripture' => 'John 3:16; Acts 4:12'
    ],
    [
        'number' => '02',
        'title' => 'Authority of the Holy Scriptures',
        'description' => 'We receive the canonical Scriptures of the Old and New Testaments as the inspired Word of God and the ultimate rule for Christian faith, doctrine, conduct and ministry.',
        'scripture' => '2 Timothy 3:16–17; Psalm 119:105'
    ],
    [
        'number' => '03',
        'title' => 'Prayer',
        'description' => 'We believe prayer is essential to the life and ministry of the Church. We are committed to personal prayer, corporate prayer, intercession and praying for those who are sick and in need.',
        'scripture' => '1 Thessalonians 5:17; James 5:14–16'
    ],
    [
        'number' => '04',
        'title' => 'Evangelism and Missions',
        'description' => 'We are committed to spreading the Gospel through evangelism, missionary work, evangelistic campaigns, Christian literature, church planting and other biblically faithful means.',
        'scripture' => 'Matthew 28:19–20; Mark 16:15'
    ],
    [
        'number' => '05',
        'title' => 'The Power and Guidance of the Holy Spirit',
        'description' => 'We depend upon the Holy Spirit to guide, empower, strengthen and equip believers for Christian life, witness and ministry.',
        'scripture' => 'Acts 1:8; John 16:13'
    ],
    [
        'number' => '06',
        'title' => 'Discipleship and Christian Education',
        'description' => 'We teach sound biblical doctrine and help believers grow in spiritual maturity through theological education, ministry training, libraries, Christian literature and responsible study.',
        'scripture' => '2 Timothy 2:2; Ephesians 4:11–13'
    ],
    [
        'number' => '07',
        'title' => 'Leadership Development',
        'description' => 'We believe in identifying, training, mentoring, licensing and ordaining qualified men and women for Christian ministry according to biblical principles and the standards established by the Church.',
        'scripture' => '2 Timothy 2:2; Ephesians 4:11–12'
    ],
    [
        'number' => '08',
        'title' => 'Holiness, Integrity and Moral Character',
        'description' => 'We uphold Christian morality, integrity, accountability and godly character among members and leaders. We encourage believers to demonstrate the character of Christ in their personal, family, church and community lives.',
        'scripture' => '1 Peter 1:15–16; Galatians 5:22–23'
    ],
    [
        'number' => '09',
        'title' => 'Compassion and Service',
        'description' => 'We are committed to demonstrating the love of Christ through compassionate service and caring for people who are poor, sick and vulnerable.',
        'scripture' => 'Official scripture references to be confirmed'
    ]
];
@endphp

    <!-- MISSION -->
    <section class="mission-section" id="mission">
        <div class="container">

            <div class="section-heading">
                <span class="section-tag">OUR PURPOSE</span>
                <h2 class="section-title">Our Mission</h2>
                <p class="section-subtitle">
                    Advancing the Kingdom of God and proclaiming
                    the Gospel of Jesus Christ to all people.
                </p>
            </div>

            <div class="mission-content">

                <p>
                    The mission of Miracle of Salvation Church is to
                    advance the Kingdom of God and proclaim the Gospel
                    of Jesus Christ to all people through evangelism,
                    prayer, biblical teaching, Christian literature,
                    missions and compassionate service.
                </p>

                <p>
                    We are committed to making disciples; training,
                    licensing and ordaining ministers of the Gospel;
                    establishing theological and ministry-training
                    institutions; planting and strengthening churches
                    and places of worship; caring for people in need;
                    praying for the sick; strengthening families;
                    and equipping believers to live lives that reflect
                    the character and teachings of Jesus Christ.
                </p>

                <p>
                    Through the power and guidance of the Holy Spirit,
                    we seek to prepare believers for Christian service
                    and extend the message of salvation to communities
                    and nations.
                </p>

            </div>

        </div>
    </section>


    <!-- VISION -->
    <section class="vision-section" id="vision">
        <div class="container vision-content">

            <span class="section-tag">OUR DESTINATION</span>

            <h2 class="section-title">Our Vision</h2>

            <p class="vision-lead">
                To see people from every nation transformed through
                salvation in Jesus Christ, established in the Word
                of God, empowered by the Holy Spirit, equipped for
                ministry and united in advancing the Kingdom of God
                throughout the world.
            </p>

            <div class="vision-detail">
                <p>
                    We envision a growing international Christian
                    ministry that establishes churches, develops
                    spiritually mature leaders, trains ministers
                    of the Gospel, strengthens families, serves
                    vulnerable people and raises future generations
                    who faithfully proclaim and demonstrate the
                    Gospel of Jesus Christ.
                </p>
            </div>

        </div>
    </section>


    <!-- CORE VALUES -->
    <section class="values-section" id="core-values">
        <div class="container">

            <div class="section-heading">
                <span class="section-tag">WHAT GUIDES US</span>
                <h2 class="section-title">Our Core Values</h2>
                <p class="section-subtitle">
                    The biblical principles that guide our faith,
                    character, decisions and ministry.
                </p>
            </div>

            <div class="values-grid">

                @foreach ($coreValues as $value)

                    <article class="value-card">

                        <span class="value-number">
                            {{ $value['number'] }}
                        </span>

                        <h3>
                            {{ $value['title'] }}
                        </h3>

                        <p>
                            {{ $value['description'] }}
                        </p>

                        <div class="value-scripture">
                            {{ $value['scripture'] }}
                        </div>

                    </article>

                @endforeach

            </div>

        </div>
    </section>
