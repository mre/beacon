<?php

namespace mre\Beacon;

use PHPUnit_Framework_TestCase;

class MetricReaderTest extends PHPUnit_Framework_TestCase
{
    /* @var $oReader MetricReader */
    private $oReader;

    protected function setUp()
    {
        $this->oReader = new MetricReader(new Validator());
    }

    public function testReaderReturnsAllCorrectMetrics()
    {
        $_aRawData = [
            'foo' => '123g',
            'bar' => '-1.9c',
            '123' => '100c',
            'baz' => '1.33g',
            'zoo' => 123,
            'maa' => '32v'
        ];

        /** @var Metric[] $_aMetrics */
        $_aMetrics = $this->oReader->read($_aRawData);

        $this->assertEquals(3, count($_aMetrics));
        $this->assertEquals('foo', $_aMetrics[0]->getKey());
        $this->assertEquals('123', $_aMetrics[0]->getValue());
        $this->assertEquals('g', $_aMetrics[0]->getType());

        $this->assertEquals('bar', $_aMetrics[1]->getKey());
        $this->assertEquals('-1.9', $_aMetrics[1]->getValue());
        $this->assertEquals('c', $_aMetrics[1]->getType());

        $this->assertEquals('baz', $_aMetrics[2]->getKey());
        $this->assertEquals('1.33', $_aMetrics[2]->getValue());
        $this->assertEquals('g', $_aMetrics[2]->getType());
    }

    public function testEmptyInputReturnsNoMetrics()
    {
        $this->assertEquals([], $this->oReader->read([]));
    }

    public function testNullInputReturnsNoMetrics()
    {
        $this->assertEquals([], $this->oReader->read(null));
    }

    public function testInvalidTypeInputReturnsNoMetrics()
    {
        $this->assertEquals([], $this->oReader->read('bla'));
    }

    public function testInvalidPointsReturnsNoMetrics()
    {
        $this->assertEquals([], $this->oReader->read(['foo' => '123']));
        $this->assertEquals([], $this->oReader->read(['foo' => 'c']));
        $this->assertEquals([], $this->oReader->read(['foo' => null]));
    }


    /**
     * @dataProvider maliciousInputProvider
     */
    public function testReaderWithMaliciousInput($sInput)
    {
        // Check input strings as malicious key and value
        $_aRawData = [
            $sInput => '123c',
            'foo' => $sInput
        ];

        /** @var Metric[] $_aMetrics */
        $_aMetrics = $this->oReader->read($_aRawData);

        // These metrics should all be invalid.
        // In other words, the number of valid metrics should be 0.
        $this->assertEquals(0, count($_aMetrics));
    }

    public function maliciousInputProvider()
    {
      return array(
        array(""),
        array("0"),
        array("1"),
        array("1.00"),
        array("$1.00"),
        array("1/2"),
        array("1E2"),
        array("1E02"),
        array("1E+02"),
        array("-1"),
        array("-1.00"),
        array("-$1.00"),
        array("-1/2"),
        array("-1E2"),
        array("-1E02"),
        array("-1E+02"),
        array("1/0"),
        array("0/0"),
        array("0.00"),
        array("0..0"),
        array("."),
        array("0.0.0"),
        array("0,00"),
        array("0,,0"),
        array(","),
        array("0,0,0"),
        array("0.0/0"),
        array("1.0/0.0"),
        array("0.0/0.0"),
        array("1,0/0,0"),
        array("0,0/0,0"),
        array("--1"),
        array("-"),
        array("-."),
        array("-,"),
        array("999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999"),
        array("-Infinity"),
        array("0x0"),
        array("0xffffffff"),
        array("0xffffffffffffffff"),
        array("0xabad1dea"),
        array("123456789012345678901234567890123456789"),
        array(",./;'[]\\-="),
        array("<>?:\"{}|_+"),
        array("!@#$%^&*()`"),
        array("Ω≈ç√∫˜µ≤≥÷"),
        array("åß∂ƒ©˙∆˚¬…æ"),
        array("œ∑´®†¥¨ˆøπ“‘"),
        array("¡™£¢∞§¶•ªº–≠"),
        array("¸˛Ç◊ı˜Â¯˘¿"),
        array("ÅÍÎÏ˝ÓÔÒÚÆ☃"),
        array("Œ„´‰ˇÁ¨ˆØ∏”’"),
        array("`⁄€‹›ﬁﬂ‡°·‚—±"),
        array("⁰⁴⁵"),
        array("₀₁₂"),
        array("⁰⁴⁵₀₁₂"),
        array("'"),
        array("\""),
        array("''"),
        array("\"\""),
        array("'\"'"),
        array("\"''''\"'\""),
        array("\"'\"'\"''''\""),
        array("田中さんにあげて下さい"),
        array("パーティーへ行かないか"),
        array("和製漢語"),
        array("部落格"),
        array("사회과학원 어학연구소"),
        array("찦차를 타고 온 펲시맨과 쑛다리 똠방각하"),
        array("社會科學院語學研究所"),
        array("울란바토르"),
        array("𠜎𠜱𠝹𠱓𠱸𠲖𠳏"),
        array("ヽ༼ຈل͜ຈ༽ﾉ ヽ༼ຈل͜ຈ༽ﾉ "),
        array("(｡◕ ∀ ◕｡)"),
        array("｀ｨ(´∀｀∩"),
        array("__ﾛ(,_,*)"),
        array("・(￣∀￣)・:*:"),
        array("ﾟ･✿ヾ╲(｡◕‿◕｡)╱✿･ﾟ"),
        array(",。・:*:・゜’( ☻ ω ☻ )。・:*:・゜’"),
        array("(╯°□°）╯︵ ┻━┻)  "),
        array("(ﾉಥ益ಥ）ﾉ﻿ ┻━┻"),
        array("😍"),
        array("👩🏽"),
        array("👾 🙇 💁 🙅 🙆 🙋 🙎 🙍 "),
        array("🐵 🙈 🙉 🙊"),
        array("❤️ 💔 💌 💕 💞 💓 💗 💖 💘 💝 💟 💜 💛 💚 💙"),
        array("✋🏿 💪🏿 👐🏿 🙌🏿 👏🏿 🙏🏿"),
        array("🚾 🆒 🆓 🆕 🆖 🆗 🆙 🏧"),
        array("0️⃣ 1️⃣ 2️⃣ 3️⃣ 4️⃣ 5️⃣ 6️⃣ 7️⃣ 8️⃣ 9️⃣ 🔟"),
        array("１２３"),
        array("١٢٣"),
        array("ثم نفس سقطت وبالتحديد،, جزيرتي باستخدام أن دنو. إذ هنا؟ الستار وتنصيب كان. أهّل ايطاليا، بريطانيا-فرنسا قد أخذ. سليمان، إتفاقية بين ما, يذكر الحدود أي بعد, معاملة بولندا، الإطلاق عل إيو."),
        array("בְּרֵאשִׁית, בָּרָא אֱלֹהִים, אֵת הַשָּׁמַיִם, וְאֵת הָאָרֶץ"),
        array("הָיְתָהtestالصفحات التّحول"),
        array("​"),
        array(" "),
        array("᠎"),
        array("　"),
        array("﻿"),
        array("␣"),
        array("␢"),
        array("␡"),
        array("‪‪test‪"),
        array("⁦test⁧"),
        array("Ṱ̺̺̕o͞ ̷i̲̬͇̪͙n̝̗͕v̟̜̘̦͟o̶̙̰̠kè͚̮̺̪̹̱̤ ̖t̝͕̳̣̻̪͞h̼͓̲̦̳̘̲e͇̣̰̦̬͎ ̢̼̻̱̘h͚͎͙̜̣̲ͅi̦̲̣̰̤v̻͍e̺̭̳̪̰-m̢iͅn̖̺̞̲̯̰d̵̼̟͙̩̼̘̳ ̞̥̱̳̭r̛̗̘e͙p͠r̼̞̻̭̗e̺̠̣͟s̘͇̳͍̝͉e͉̥̯̞̲͚̬͜ǹ̬͎͎̟̖͇̤t͍̬̤͓̼̭͘ͅi̪̱n͠g̴͉ ͏͉ͅc̬̟h͡a̫̻̯͘o̫̟̖͍̙̝͉s̗̦̲.̨̹͈̣"),
        array("̡͓̞ͅI̗̘̦͝n͇͇͙v̮̫ok̲̫̙͈i̖͙̭̹̠̞n̡̻̮̣̺g̲͈͙̭͙̬͎ ̰t͔̦h̞̲e̢̤ ͍̬̲͖f̴̘͕̣è͖ẹ̥̩l͖͔͚i͓͚̦͠n͖͍̗͓̳̮g͍ ̨o͚̪͡f̘̣̬ ̖̘͖̟͙̮c҉͔̫͖͓͇͖ͅh̵̤̣͚͔á̗̼͕ͅo̼̣̥s̱͈̺̖̦̻͢.̛̖̞̠̫̰"),
        array("̗̺͖̹̯͓Ṯ̤͍̥͇͈h̲́e͏͓̼̗̙̼̣͔ ͇̜̱̠͓͍ͅN͕͠e̗̱z̘̝̜̺͙p̤̺̹͍̯͚e̠̻̠͜r̨̤͍̺̖͔̖̖d̠̟̭̬̝͟i̦͖̩͓͔̤a̠̗̬͉̙n͚͜ ̻̞̰͚ͅh̵͉i̳̞v̢͇ḙ͎͟-҉̭̩̼͔m̤̭̫i͕͇̝̦n̗͙ḍ̟ ̯̲͕͞ǫ̟̯̰̲͙̻̝f ̪̰̰̗̖̭̘͘c̦͍̲̞͍̩̙ḥ͚a̮͎̟̙͜ơ̩̹͎s̤.̝̝ ҉Z̡̖̜͖̰̣͉̜a͖̰͙̬͡l̲̫̳͍̩g̡̟̼̱͚̞̬ͅo̗͜.̟"),
        array("̦H̬̤̗̤͝e͜ ̜̥̝̻͍̟́w̕h̖̯͓o̝͙̖͎̱̮ ҉̺̙̞̟͈W̷̼̭a̺̪͍į͈͕̭͙̯̜t̶̼̮s̘͙͖̕ ̠̫̠B̻͍͙͉̳ͅe̵h̵̬͇̫͙i̹͓̳̳̮͎̫̕n͟d̴̪̜̖ ̰͉̩͇͙̲͞ͅT͖̼͓̪͢h͏͓̮̻e̬̝̟ͅ ̤̹̝W͙̞̝͔͇͝ͅa͏͓͔̹̼̣l̴͔̰̤̟͔ḽ̫.͕"),
        array("Z̮̞̠͙͔ͅḀ̗̞͈̻̗Ḷ͙͎̯̹̞͓G̻O̭̗̮"),
        array("˙ɐnbᴉlɐ ɐuƃɐɯ ǝɹolop ʇǝ ǝɹoqɐl ʇn ʇunpᴉpᴉɔuᴉ ɹodɯǝʇ poɯsnᴉǝ op pǝs 'ʇᴉlǝ ƃuᴉɔsᴉdᴉpɐ ɹnʇǝʇɔǝsuoɔ 'ʇǝɯɐ ʇᴉs ɹolop ɯnsdᴉ ɯǝɹo˥"),
        array("00˙Ɩ$-"),
        array("Ｔｈｅ ｑｕｉｃｋ ｂｒｏｗｎ ｆｏｘ ｊｕｍｐｓ ｏｖｅｒ ｔｈｅ ｌａｚｙ ｄｏｇ"),
        array("𝐓𝐡𝐞 𝐪𝐮𝐢𝐜𝐤 𝐛𝐫𝐨𝐰𝐧 𝐟𝐨𝐱 𝐣𝐮𝐦𝐩𝐬 𝐨𝐯𝐞𝐫 𝐭𝐡𝐞 𝐥𝐚𝐳𝐲 𝐝𝐨𝐠"),
        array("𝕿𝖍𝖊 𝖖𝖚𝖎𝖈𝖐 𝖇𝖗𝖔𝖜𝖓 𝖋𝖔𝖝 𝖏𝖚𝖒𝖕𝖘 𝖔𝖛𝖊𝖗 𝖙𝖍𝖊 𝖑𝖆𝖟𝖞 𝖉𝖔𝖌"),
        array("𝑻𝒉𝒆 𝒒𝒖𝒊𝒄𝒌 𝒃𝒓𝒐𝒘𝒏 𝒇𝒐𝒙 𝒋𝒖𝒎𝒑𝒔 𝒐𝒗𝒆𝒓 𝒕𝒉𝒆 𝒍𝒂𝒛𝒚 𝒅𝒐𝒈"),
        array("𝓣𝓱𝓮 𝓺𝓾𝓲𝓬𝓴 𝓫𝓻𝓸𝔀𝓷 𝓯𝓸𝔁 𝓳𝓾𝓶𝓹𝓼 𝓸𝓿𝓮𝓻 𝓽𝓱𝓮 𝓵𝓪𝔃𝔂 𝓭𝓸𝓰"),
        array("𝕋𝕙𝕖 𝕢𝕦𝕚𝕔𝕜 𝕓𝕣𝕠𝕨𝕟 𝕗𝕠𝕩 𝕛𝕦𝕞𝕡𝕤 𝕠𝕧𝕖𝕣 𝕥𝕙𝕖 𝕝𝕒𝕫𝕪 𝕕𝕠𝕘"),
        array("𝚃𝚑𝚎 𝚚𝚞𝚒𝚌𝚔 𝚋𝚛𝚘𝚠𝚗 𝚏𝚘𝚡 𝚓𝚞𝚖𝚙𝚜 𝚘𝚟𝚎𝚛 𝚝𝚑𝚎 𝚕𝚊𝚣𝚢 𝚍𝚘𝚐"),
        array("⒯⒣⒠ ⒬⒰⒤⒞⒦ ⒝⒭⒪⒲⒩ ⒡⒪⒳ ⒥⒰⒨⒫⒮ ⒪⒱⒠⒭ ⒯⒣⒠ ⒧⒜⒵⒴ ⒟⒪⒢"),
        array("<script>alert('XSS')</script>"),
        array("<img src=x onerror=alert('XSS') />"),
        array("<svg><script>0<1>alert('XSS')</script> "),
        array("\"><script>alert(document.title)</script>"),
        array("'><script>alert(document.title)</script>"),
        array("><script>alert(document.title)</script>"),
        array("</script><script>alert(document.title)</script>"),
        array("< / script >< script >alert(document.title)< / script >"),
        array(" onfocus=alert(document.title) autofocus "),
        array("\" onfocus=alert(document.title) autofocus "),
        array("' onfocus=alert(document.title) autofocus "),
        array("＜script＞alert(document.title)＜/script＞"),
        array("<sc<script>ript>alert('XSS')</sc</script>ript>"),
        array("--><script>alert(0)</script>"),
        array("\";alert(0);t=\""),
        array("';alert(0);t='"),
        array("JavaSCript:alert(0)"),
        array(";alert(0);"),
        array("src=JaVaSCript:prompt(9)"),
        array("1;DROP TABLE users"),
        array("1'; DROP TABLE users--"),
        array("-"),
        array("--"),
        array("--version"),
        array("--help"),
        array('$USER'),
        array("/dev/null; touch /tmp/blns.fail ; echo"),
        array("`touch /tmp/blns.fail`"),
        array("$(touch /tmp/blns.fail)"),
        array("@{[system \"touch /tmp/blns.fail\"]}"),
        array("eval(\"puts 'hello world'\")"),
        array("System(\"ls -al /\")"),
        array("`ls -al /`"),
        array("Kernel.exec(\"ls -al /\")"),
        array("Kernel.exit(1)"),
        array("%x('ls -al /')"),
        array("<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?><!DOCTYPE foo [ <!ELEMENT foo ANY ><!ENTITY xxe SYSTEM \"file:///etc/passwd\" >]><foo>&xxe;</foo>"),
        array('$HOME'),
        array('$ENV{"HOME"}'),
        array("%d"),
        array("%s"),
        array("%*.*s"),
        array("../../../../../../../../../../../etc/passwd%00"),
        array("../../../../../../../../../../../etc/hosts"),
        array("() { 0; }; touch /tmp/blns.shellshock1.fail;"),
        array("() { _; } >_[$($())] { touch /tmp/blns.shellshock2.fail; }"),
        array("CLOCK$"),
        array("A:"),
        array("ZZ:"),
        array("COM1"),
        array("LPT1"),
        array("LPT2"),
        array("LPT3"),
        array("COM2"),
        array("COM3"),
        array("COM4"),
        array("If you're reading this, you've been in coma for almost 20 years now. We're trying a new technique. We don't know where this message will end up in your dream, but we hope it works. Please wake up, we miss you."),
        array("Roses are \u001b[0;31mred\u001b[0m, violets are \u001b[0;34mblue. Hope you enjoy terminal hue"),
        array("But now...\u001b[20Cfor my greatest trick...\u001b[8m"),
        array("Powerلُلُصّبُلُلصّبُررً ॣ ॣh )(())ॣ ॣ冗"));
    }
}
