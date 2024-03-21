<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rahulpranami.co
 * @since      1.0.0
 *
 * @package    Mailtrap
 * @subpackage Mailtrap/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mailtrap
 * @subpackage Mailtrap/admin
 * @author     Rahul Pranami <rahulpranami101@gmail.com>
 */
class Mailtrap_API {

    const BASE_URL = 'https://mailtrap.io/api/v1';

    public static function getInboxes() {
        $response = wp_remote_get(self::BASE_URL . '/inboxes', [
            'headers' => [
                'Api-Token' => get_option('mailtrap_api_token')
            ]
        ]);

        if (is_array($response) && !is_wp_error($response)) {
            if (200 != $response['response']['code']) {
                throw new Exception($response['response']['message'], $response['response']['code']);
            }

            return json_decode($response['body']);
        }
    }

    public static function getInboxMessages($id) {
        // print_r($id);
        $id = get_option('mailtrap_inbox_id');
        $response = wp_remote_get(self::BASE_URL . '/inboxes/' . $id . '/messages', [
            'headers' => [
                'Api-Token' => get_option('mailtrap_api_token')
            ]
        ]);

        if (is_array($response) && !is_wp_error($response)) {
            if (200 != $response['response']['code']) {
                throw new Exception($response['response']['message'], $response['response']['code']);
            }

            return json_decode($response['body']);
        }
    }

    public static function getMessage($inbox_id, $message_id) {
        $response = wp_remote_get(self::BASE_URL . '/inboxes/' . $inbox_id . '/messages/' . $message_id, [
            'headers' => [
                'Api-Token' => get_option('mailtrap_api_token')
            ]
        ]);

        if (is_array($response) && !is_wp_error($response)) {
            if (200 != $response['response']['code']) {
                throw new Exception($response['response']['message'], $response['response']['code']);
            }

            return json_decode($response['body']);
        }
    }

    public static function getMessageBody($inbox_id, $message_id, $format = 'html') {
        $response = wp_remote_get(self::BASE_URL . '/inboxes/' . $inbox_id . '/messages/' . $message_id . '/body.' . $format, [
            'headers' => [
                'Api-Token' => get_option('mailtrap_api_token')
            ]
        ]);

        if (is_array($response) && !is_wp_error($response)) {
            if (200 != $response['response']['code'] && 404 != $response['response']['code']) {
                throw new Exception($response['response']['message'], $response['response']['code']);
            }

            if (404 != $response['response']['code']) {
                return self::getMessageBody($inbox_id, $message_id, 'txt');
            }
            return $response['body'];
        }
    }

    public static function time2str($ts) {
        if (!ctype_digit($ts))
            $ts = strtotime($ts);

        $diff = time() - $ts;
        if ($diff == 0)
            return 'now';
        elseif ($diff > 0) {
            $day_diff = floor($diff / 86400);
            if ($day_diff == 0) {
                if ($diff < 60)
                    return 'just now';
                if ($diff < 120)
                    return '1 minute ago';
                if ($diff < 3600)
                    return floor($diff / 60) . ' minutes ago';
                if ($diff < 7200)
                    return '1 hour ago';
                if ($diff < 86400)
                    return floor($diff / 3600) . ' hours ago';
            }
            if ($day_diff == 1)
                return 'Yesterday';
            if ($day_diff < 7)
                return $day_diff . ' days ago';
            if ($day_diff < 31)
                return ceil($day_diff / 7) . ' weeks ago';
            if ($day_diff < 60)
                return 'last month';
            return date('F Y', $ts);
        } else {
            $diff = abs($diff);
            $day_diff = floor($diff / 86400);
            if ($day_diff == 0) {
                if ($diff < 120)
                    return 'in a minute';
                if ($diff < 3600)
                    return 'in ' . floor($diff / 60) . ' minutes';
                if ($diff < 7200)
                    return 'in an hour';
                if ($diff < 86400)
                    return 'in ' . floor($diff / 3600) . ' hours';
            }
            if ($day_diff == 1)
                return 'Tomorrow';
            if ($day_diff < 4)
                return date('l', $ts);
            if ($day_diff < 7 + (7 - date('w')))
                return 'next week';
            if (ceil($day_diff / 7) < 4)
                return 'in ' . ceil($day_diff / 7) . ' weeks';
            if (date('n', $ts) == date('n') + 1)
                return 'next month';
            return date('F Y', $ts);
        }
    }

}
