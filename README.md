# Buto-Plugin-OpenaiApi_v1

<p>This plugin is for testing purpose agains api on server api.openai.com.</p>

<a name="key_0"></a>

## Settings

<p>Put param api_key in this file.</p>
<pre><code>plugin:
  openai:
    api_v1:
      settings: 'yml:/../buto_data/theme/[theme]/openai_api_v1.yml'</code></pre>

<a name="key_1"></a>

## Usage

<ul>
<li>Set up api key.</li>
<li>Add a page with test widget.</li>
<li>Edit widget data to test api.</li>
</ul>

<a name="key_2"></a>

## Widgets



<a name="key_2_0"></a>

### widget_test

<p>Widget to test api.
Change data for every new test.</p>
<pre><code>type: widget
data:
  plugin: openai/api_v1
  method: test
  data:
    model: gpt-3.5-turbo
    messages:
      -
        role: system
        content: 'You are a helpful assistant.'
      -
        role: user
        content: 'Who is Donald Trump?'
    max_tokens: 100
    temperature: 0.7</code></pre>

<a name="key_3"></a>

## Construct



<a name="key_3_0"></a>

### __construct

<p>Handle settings.</p>

<a name="key_4"></a>

## Methods



<a name="key_4_0"></a>

### log

<p>Log file /log/990101.yml to buto_data theme folder.</p>

