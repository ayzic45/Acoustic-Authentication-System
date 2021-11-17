%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% Time & Frequency Domain for Transmitted signals
% .wav data for both transmitted and recieved signal were obtained 
% seperately, i.e transmitted signal are exported from the SDL
% using the command line at ubuntu
% recieved signal are exported after the recording at reciever side
% using javascripts at reciever1.php, extracted from the 
% original reciever.php 
% then there are imported here on MATLAB analysis
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
fs = 44e3 ; % default value of sampling frequency 44kHz

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%                    1
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%Transmitted Signal for "UKZN-ACOUSTIC-AUTHENTICATION"
acoustic_auth_data = 'TEST1.wav';
[data_set, y] = audioread(acoustic_auth_data);
x = data_set ; % column to row vector conversion
sound(x, y);
%use the plot_funct
plot_func(x, fs,'Amplitude', 'TRANSMITTED WAVEFORM FOR "UKZN-ACOUSTIC-AUTHENTICA"');

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%                    2
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%Transmitted Signal for "UKZN#CodeTest1234_5"
acoustic_auth_data = 'TEST2.wav';
[data_set, y] = audioread(acoustic_auth_data);
x = data_set ; % column to row vector conversion
sound(x, y);
plot_func(x, fs,'Amplitude', 'TRANSMITTED WAVEFORM FOR "UKZN#CodeTest1234_5"');


%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%                    3
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%Transmitted Signal for "UKZN#CodeTest1234_5"
acoustic_auth_data = 'AYA796- DeopvJBqVH4xzMmjAPE02gu.wav';
[data_set, y] = audioread(acoustic_auth_data);
x = data_set ; % column to row vector conversion
sound(x, y);
plot_func(x, fs,'Amplitude', 'TRANSMITTED WAVEFORM FOR "DeopvJBqVH4xzMmjAPE02gu"');

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%                    4
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%Transmitted Signal for "UKZN#CodeTest1234_5"
acoustic_auth_data = 'AYA4545- 7zAM5OhYmNdu9gJy1QVSZI2e.wav';
[data_set, y] = audioread(acoustic_auth_data);
x = data_set ; % column to row vector conversion
sound(x, y);
plot_func(x, fs,'Amplitude', 'TRANSMITTED WAVEFORM FOR "7zAM5OhYmNdu9gJy1QVSZI2e"');

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%                    5
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%Transmitted Signal for "UKZN#CodeTest1234_5"
acoustic_auth_data = 'Sabza18- kXNZBmjYTLqFMCcEgv-tedo3.wav';
[data_set, y] = audioread(acoustic_auth_data);
x = data_set ; % column to row vector conversion
sound(x, y);
plot_func(x, fs,'Amplitude', 'TRANSMITTED WAVEFORM FOR "kXNZBmjYTLqFMCcEgv-tedo3"');

