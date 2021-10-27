"use strict";(self.webpackChunkopenapi_attributes=self.webpackChunkopenapi_attributes||[]).push([[361],{478:(n,s,a)=>{a.r(s),a.d(s,{data:()=>t});const t={key:"v-31036194",path:"/routes.html",title:"Definition routes",lang:"en-US",frontmatter:{lang:"en-US",title:"Definition routes"},excerpt:"",headers:[],filePathRelative:"routes.md",git:{updatedTime:1633893568e3,contributors:[{name:"AkioSarkiz",email:"akiosarkiz@gmail.com",commits:4}]}}},410:(n,s,a)=>{a.r(s),a.d(s,{default:()=>p});const t=(0,a(252).uE)('<h4 id="define-simple-routes" tabindex="-1"><a class="header-anchor" href="#define-simple-routes" aria-hidden="true">#</a> Define simple routes</h4><div class="language-php ext-php line-numbers-mode"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">OpenApiGenerator<span class="token punctuation">\\</span>Attributes<span class="token punctuation">\\</span>Property<span class="token punctuation">\\</span>Str</span><span class="token punctuation">;</span>\n\n<span class="token keyword">class</span> <span class="token class-name-definition class-name">SimpleController</span>\n<span class="token punctuation">{</span>\n    <span class="token attribute"><span class="token delimiter punctuation">#[</span><span class="token attribute-content">\n        <span class="token attribute-class-name class-name">Get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/path&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string single-quoted-string">&#39;Dummy&#39;</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;path&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>\n        <span class="token attribute-class-name class-name">Str</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;test&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>\n        \n        <span class="token attribute-class-name class-name">Response</span><span class="token punctuation">(</span><span class="token number">200</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;the description&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>\n    </span><span class="token delimiter punctuation">]</span></span>\n    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">get</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">void</span>\n    <span class="token punctuation">{</span>\n        <span class="token comment">//</span>\n    <span class="token punctuation">}</span>\n<span class="token punctuation">}</span>\n</code></pre><div class="line-numbers"><span class="line-number">1</span><br><span class="line-number">2</span><br><span class="line-number">3</span><br><span class="line-number">4</span><br><span class="line-number">5</span><br><span class="line-number">6</span><br><span class="line-number">7</span><br><span class="line-number">8</span><br><span class="line-number">9</span><br><span class="line-number">10</span><br><span class="line-number">11</span><br><span class="line-number">12</span><br><span class="line-number">13</span><br><span class="line-number">14</span><br><span class="line-number">15</span><br></div></div><h4 id="define-advanced-routes" tabindex="-1"><a class="header-anchor" href="#define-advanced-routes" aria-hidden="true">#</a> Define advanced routes</h4><div class="language-php ext-php line-numbers-mode"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">OpenApiGenerator<span class="token punctuation">\\</span>Attributes<span class="token punctuation">\\</span>Property<span class="token punctuation">\\</span>Number</span><span class="token punctuation">;</span>\n<span class="token keyword">use</span> <span class="token package">OpenApiGenerator<span class="token punctuation">\\</span>Attributes<span class="token punctuation">\\</span>Property<span class="token punctuation">\\</span>Obj</span><span class="token punctuation">;</span>\n<span class="token keyword">use</span> <span class="token package">OpenApiGenerator<span class="token punctuation">\\</span>Attributes<span class="token punctuation">\\</span>Property<span class="token punctuation">\\</span>Boolean</span><span class="token punctuation">;</span>\n\n<span class="token keyword">class</span> <span class="token class-name-definition class-name">Controller</span>\n<span class="token punctuation">{</span>\n    <span class="token attribute"><span class="token delimiter punctuation">#[</span><span class="token attribute-content">\n        <span class="token attribute-class-name class-name">Get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/path/{id}&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string single-quoted-string">&#39;Dummy&#39;</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;Dummy path&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>\n        <span class="token attribute-class-name class-name">Number</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;id&#39;</span><span class="token punctuation">,</span> <span class="token attribute-class-name class-name">description</span><span class="token punctuation">:</span> <span class="token string single-quoted-string">&#39;id of dummy&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>\n        <span class="token attribute-class-name class-name">Obj</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;test&#39;</span><span class="token punctuation">,</span> <span class="token attribute-class-name class-name">properties</span><span class="token punctuation">:</span> <span class="token punctuation">[</span>\n            <span class="token string single-quoted-string">&#39;data&#39;</span> <span class="token operator">=&gt;</span> <span class="token attribute-class-name class-name">PropertyType</span><span class="token operator">::</span><span class="token constant">STRING</span><span class="token punctuation">,</span>\n            <span class="token string single-quoted-string">&#39;item&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>\n                <span class="token string single-quoted-string">&#39;type&#39;</span> <span class="token operator">=&gt;</span> <span class="token attribute-class-name class-name">PropertyType</span><span class="token operator">::</span><span class="token constant">STRING</span><span class="token punctuation">,</span>\n            <span class="token punctuation">]</span><span class="token punctuation">,</span>\n            <span class="token string single-quoted-string">&#39;anotherObject&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>\n                <span class="token string single-quoted-string">&#39;type&#39;</span> <span class="token operator">=&gt;</span> <span class="token attribute-class-name class-name">PropertyType</span><span class="token operator">::</span><span class="token constant">OBJECT</span><span class="token punctuation">,</span>\n                <span class="token string single-quoted-string">&#39;properties&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>\n                    <span class="token string single-quoted-string">&#39;output.json&#39;</span> <span class="token operator">=&gt;</span> <span class="token attribute-class-name class-name">PropertyType</span><span class="token operator">::</span><span class="token constant">STRING</span><span class="token punctuation">,</span>\n                <span class="token punctuation">]</span><span class="token punctuation">,</span>\n            <span class="token punctuation">]</span><span class="token punctuation">,</span>\n        <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">,</span>\n        \n        <span class="token attribute-class-name class-name">Response</span><span class="token punctuation">(</span><span class="token number">200</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;the description&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>\n        <span class="token attribute-class-name class-name">Boolean</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;success&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>\n    </span><span class="token delimiter punctuation">]</span></span>\n    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">get</span><span class="token punctuation">(</span><span class="token keyword type-hint">float</span> <span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">void</span> <span class="token punctuation">{</span>\n        <span class="token comment">//</span>\n    <span class="token punctuation">}</span>\n<span class="token punctuation">}</span>\n\n</code></pre><div class="line-numbers"><span class="line-number">1</span><br><span class="line-number">2</span><br><span class="line-number">3</span><br><span class="line-number">4</span><br><span class="line-number">5</span><br><span class="line-number">6</span><br><span class="line-number">7</span><br><span class="line-number">8</span><br><span class="line-number">9</span><br><span class="line-number">10</span><br><span class="line-number">11</span><br><span class="line-number">12</span><br><span class="line-number">13</span><br><span class="line-number">14</span><br><span class="line-number">15</span><br><span class="line-number">16</span><br><span class="line-number">17</span><br><span class="line-number">18</span><br><span class="line-number">19</span><br><span class="line-number">20</span><br><span class="line-number">21</span><br><span class="line-number">22</span><br><span class="line-number">23</span><br><span class="line-number">24</span><br><span class="line-number">25</span><br><span class="line-number">26</span><br><span class="line-number">27</span><br><span class="line-number">28</span><br><span class="line-number">29</span><br><span class="line-number">30</span><br></div></div><h5 id="response-array" tabindex="-1"><a class="header-anchor" href="#response-array" aria-hidden="true">#</a> Response array</h5><div class="language-php ext-php line-numbers-mode"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">OpenApiGenerator<span class="token punctuation">\\</span>Attributes<span class="token punctuation">\\</span>Property<span class="token punctuation">\\</span>Str</span><span class="token punctuation">;</span>\n<span class="token keyword">use</span> <span class="token package">OpenApiGenerator<span class="token punctuation">\\</span>Attributes<span class="token punctuation">\\</span>Property<span class="token punctuation">\\</span>Obj</span><span class="token punctuation">;</span>\n<span class="token keyword">use</span> <span class="token package">OpenApiGenerator<span class="token punctuation">\\</span>Attributes<span class="token punctuation">\\</span>Property<span class="token punctuation">\\</span>Number</span><span class="token punctuation">;</span>\n\n<span class="token keyword">class</span> <span class="token class-name-definition class-name">Controller</span>\n<span class="token punctuation">{</span>\n    <span class="token attribute"><span class="token delimiter punctuation">#[</span><span class="token attribute-content">\n        <span class="token attribute-class-name class-name">Get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/path/{id}&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string single-quoted-string">&#39;Dummy&#39;</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;Dummy path&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>\n\n        <span class="token attribute-class-name class-name">Response</span><span class="token punctuation">(</span><span class="token number">200</span><span class="token punctuation">,</span> <span class="token attribute-class-name class-name">type</span><span class="token punctuation">:</span> <span class="token string single-quoted-string">&#39;array&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>\n        <span class="token attribute-class-name class-name">Obj</span><span class="token punctuation">(</span><span class="token attribute-class-name class-name">properties</span><span class="token punctuation">:</span> <span class="token punctuation">[</span>\n            <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token attribute-class-name class-name">PropertyType</span><span class="token operator">::</span><span class="token constant">STRING</span><span class="token punctuation">,</span>\n            <span class="token string single-quoted-string">&#39;password&#39;</span> <span class="token operator">=&gt;</span> <span class="token attribute-class-name class-name">PropertyType</span><span class="token operator">::</span><span class="token constant">STRING</span><span class="token punctuation">,</span>\n            <span class="token string single-quoted-string">&#39;age&#39;</span> <span class="token operator">=&gt;</span> <span class="token attribute-class-name class-name">PropertyType</span><span class="token operator">::</span><span class="token constant">INT</span><span class="token punctuation">,</span>\n        <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">,</span>\n\n        <span class="token attribute-class-name class-name">Response</span><span class="token punctuation">(</span><span class="token number">400</span><span class="token punctuation">,</span> <span class="token attribute-class-name class-name">type</span><span class="token punctuation">:</span> <span class="token string single-quoted-string">&#39;array&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>\n        <span class="token attribute-class-name class-name">Str</span><span class="token punctuation">,</span>\n\n        <span class="token attribute-class-name class-name">Response</span><span class="token punctuation">(</span><span class="token number">500</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;the description&#39;</span><span class="token punctuation">,</span> <span class="token attribute-class-name class-name">type</span><span class="token punctuation">:</span> <span class="token string single-quoted-string">&#39;array&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>\n        <span class="token attribute-class-name class-name">Number</span><span class="token punctuation">,</span>\n    </span><span class="token delimiter punctuation">]</span></span>\n    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">get</span><span class="token punctuation">(</span><span class="token keyword type-hint">float</span> <span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">void</span> <span class="token punctuation">{</span>\n        <span class="token comment">//</span>\n    <span class="token punctuation">}</span>\n<span class="token punctuation">}</span>\n</code></pre><div class="line-numbers"><span class="line-number">1</span><br><span class="line-number">2</span><br><span class="line-number">3</span><br><span class="line-number">4</span><br><span class="line-number">5</span><br><span class="line-number">6</span><br><span class="line-number">7</span><br><span class="line-number">8</span><br><span class="line-number">9</span><br><span class="line-number">10</span><br><span class="line-number">11</span><br><span class="line-number">12</span><br><span class="line-number">13</span><br><span class="line-number">14</span><br><span class="line-number">15</span><br><span class="line-number">16</span><br><span class="line-number">17</span><br><span class="line-number">18</span><br><span class="line-number">19</span><br><span class="line-number">20</span><br><span class="line-number">21</span><br><span class="line-number">22</span><br><span class="line-number">23</span><br><span class="line-number">24</span><br><span class="line-number">25</span><br><span class="line-number">26</span><br></div></div>',6),p={render:function(n,s){return t}}}}]);