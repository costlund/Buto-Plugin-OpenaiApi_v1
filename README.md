# Buto-Plugin-OpenaiApi_v1

<p>API for api.openai.com.</p>

<a name="key_0"></a>

## Settings



<p>Put param api_key in this file.</p>
<pre><code>plugin:
  openai:
    api_v1:
      settings: 'yml:/../buto_data/theme/[theme]/openai_api_v1.yml'</code></pre>
<p>In settings file.</p>
<pre><code>api_key: _my_api_key_</code></pre>

<a name="key_1"></a>

## Usage



<p>Data.</p>
<pre><code>model: gpt-3.5-turbo
messages:
  -
    role: user
    content: "How old is the world!"
max_tokens: 1000
temperature: 0.7</code></pre>
<p>PHP.</p>
<pre><code>$ai = new PluginOpenaiApi_v1();
$response = $ai-&gt;api_chat_completions($data, 'my_request_tag_optional');</code></pre>
<p>Result.</p>
<pre><code>id: chat-id
object: chat.completion
created: 1783012530
model: gpt-3.5-turbo-0125
choices:
  -
    index: 0
    message:
      role: assistant
      content: 'The Earth is approximately 4.5 billion years old.'
      refusal: null
      annotations: {  }
    logprobs: null
    finish_reason: stop
usage:
  prompt_tokens: 13
  completion_tokens: 12
  total_tokens: 25
  prompt_tokens_details:
    cached_tokens: 0
    audio_tokens: 0
  completion_tokens_details:
    reasoning_tokens: 0
    audio_tokens: 0
    accepted_prediction_tokens: 0
    rejected_prediction_tokens: 0
service_tier: default
system_fingerprint: null
db:
  created_at: '2026-07-02 19:15:32'
  id: 2836000036a469cb4033ba375103454
  tag: my_request_tag_optional
  request:
    model: gpt-3.5-turbo
    messages:
      -
        role: user
        content: 'How old is the world!'
    max_tokens: 1000
    temperature: 0.7</code></pre>

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

