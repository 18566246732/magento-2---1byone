+ 排序问题
    + discount要限定两位，比如5要写做05
    + suggest按照字符比较规则进行排序
+ faq规范：
    + 一组问答与下一组问答之间有一个空行隔开
    + 问题用Q：开头，用换行结尾,问题内部不允许换行
    + 答案以A:开头，中间可以换行，但是不允许有空行
    + 例子
    <pre><code>
  Q: Can I use other Micro USB cabls other than the one that came with PowerCore Fusion 5000?
  A: Yes, other Micro USB cables can be used to charge your devices with PowerCore Fusion 5000. However, to ensure compatibility and the best possible performance, we strongly recommend using your device’s original (OEM) cable, a third-party certified (MFI) cable, or the included cable. 
        
  Q: What devices are compatible with PowerCore Fusion 5000?
  A: The PowerCore Fusion 5000 is compatible with Android, Apple and almost all other devices charged via USB except for iPod nano, iPod Classic, HP TouchPad, Asus tablets and some GPS and Bluetooth devices. 
    </code></pre>
+ download files规范：
    + 每个文件占一行
    + 每个文件的格式为<显示名称>:<相对地址>
    + 例如：
    <pre><code>
  file_name1:sku1/file1.pdf
  file_name2:sku2/file2.pdf
    </code></pre>
    同时，将相应文件上传到pub/media/download_files文件夹下，建议文件用产品的sku作为目录以进行区分

