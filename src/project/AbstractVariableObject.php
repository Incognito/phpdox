<?php
    /**
     * Copyright (c) 2010-2013 Arne Blankerts <arne@blankerts.de>
     * All rights reserved.
     *
     * Redistribution and use in source and binary forms, with or without modification,
     * are permitted provided that the following conditions are met:
     *
     *   * Redistributions of source code must retain the above copyright notice,
     *     this list of conditions and the following disclaimer.
     *
     *   * Redistributions in binary form must reproduce the above copyright notice,
     *     this list of conditions and the following disclaimer in the documentation
     *     and/or other materials provided with the distribution.
     *
     *   * Neither the name of Arne Blankerts nor the names of contributors
     *     may be used to endorse or promote products derived from this software
     *     without specific prior written permission.
     *
     * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
     * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT  * NOT LIMITED TO,
     * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
     * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER ORCONTRIBUTORS
     * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
     * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
     * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
     * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
     * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
     * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
     * POSSIBILITY OF SUCH DAMAGE.
     *
     * @package    phpDox
     * @author     Arne Blankerts <arne@blankerts.de>
     * @copyright  Arne Blankerts <arne@blankerts.de>, All rights reserved.
     * @license    BSD License
     */
namespace TheSeer\phpDox\Project {

    use TheSeer\fDOM\fDOMElement;

    abstract class AbstractVariableObject {

        const XMLNS = 'http://xml.phpdox.de/src#';

        protected  $ctx;

        private $types = array('{unknown}', 'object', 'array','integer','float','string','boolean','resource');

        public function __construct(fDOMElement $ctx) {
            $this->ctx = $ctx;
        }

        public function export() {
            return $this->ctx;
        }

        public function setLine($line) {
            $this->ctx->setAttribute('line', $line);
        }

        public function getLine() {
            return $this->ctx->getAttribute('line');
        }

        public function setName($name) {
            $this->ctx->setAttribute('name', $name);
        }

        public function getName() {
            return $this->ctx->getAttributeNode('name');
        }

        public function setDefault($value) {
            $this->ctx->setAttribute('default', $value);
        }

        public function setType($type) {
            if (!in_array(strtolower($type), $this->types)) {
                $parts = explode('\\', $type);
                $local = array_pop($parts);
                $namespace = join('\\', $parts);

                $unit = $this->ctx->appendElementNS(self::XMLNS, 'type');
                $unit->setAttribute('full', $type);
                $unit->setAttribute('namespace', $namespace);
                $unit->setAttribute('name', $local);
                $type = 'object';
            }
            $this->ctx->setAttribute('type', $type);
        }

        public function getType() {
            return $this->ctx->getAttribute('type');
        }

    }
}
