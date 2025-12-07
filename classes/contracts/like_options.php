<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace local_sqlquerybuilder\contracts;

/**
 * Options to compare two strings
 *
 * @package     local_sqlquerybuilder
 * @copyright   2025, Konrad Ebel <despair2400@proton.me>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class like_options {
    /** @param bool $casesensitive Whether to differ between small and big letters, e.g. A or a */
    public bool $casesensitive = false;

    /** @param bool $accentsensitive Whether to differ between letters with accents or without, e.g. á or a */
    public bool $accentsensitive = false;

    /** @param bool $escape Whether to escape given string (needed if want to search for % or _) */
    public bool $escape = false;

    /** @param bool $escapestring What to use as escape string */
    public string $escapestring = '\\';
}
